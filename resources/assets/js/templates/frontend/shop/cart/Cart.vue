<template>
    <div>
        <div v-if="items.length !== 0">
            <div class="pre-content">
                <v-layout row wrap>
                    <v-flex d-flex xs12 sm6 justify-start align-center>
                        <h1 class="headline" v-html="$t('content.frontend.shop.cart.total', {sum: total, currency: $store.state.shop.currency.html})"></h1>
                    </v-flex>
                    <v-flex d-flex xs12 sm3 offset-sm3 justify-end>
                        <v-btn
                                class="mb-3"
                                round
                                block
                                outline
                                color="orange"
                                :loading="loadingPurchaseBtn"
                                @click="reCaptchaKey || !$store.getters.isAuth ? dialog = true : purchase()"
                        >{{ $t('content.frontend.shop.cart.purchase') }}</v-btn>
                    </v-flex>
                </v-layout>
            </div>

            <v-divider class="mb-3"></v-divider>

            <shop-grid>
                <cart-item
                        v-for="item in items"
                        :key="item.product.id"
                        :id="item.product.id"
                        :name="item.product.item.name"
                        :image="item.product.item.image"
                        :price="item.product.price"
                        :stack="item.product.stack"
                        :is-item="item.product.item.type.isItem"
                        :is-permgroup="item.product.item.type.isPermgroup"
                        :enchantments="item.product.item.enchantments"
                        @remove="remove"
                        @recount="recount"
                        @resum="resum"
                ></cart-item>
            </shop-grid>
            <purchase-dialog
                    v-if="reCaptchaKey || !$store.getters.isAuth"
                    :dialog="dialog"
                    :items="purchaseItems"
                    :captcha-key="reCaptchaKey"
                    @success="clear"
                    @hide="dialog = false"
            ></purchase-dialog>
        </div>
        <v-layout align-center justify-center class="headline" v-else>
            {{ $t('content.frontend.shop.cart.empty') }}
        </v-layout>
    </div>
</template>

<script>
    import loader from './../../../../core/http/loader'
    import CartItem from './Item.vue'
    import PurchaseDialog from './PurchaseDialog.vue'

    export default {
        data() {
            return {
                total: 0,
                items: [],
                purchaseItems: [],
                dialog: false,
                loadingPurchaseBtn: false,
                reCaptchaKey: null
            }
        },
        beforeRouteEnter(to, from, next) {
            loader.beforeRouteEnter(`/spa/cart/${to.params.server}`, to, from, next);
        },
        beforeRouteUpdate(to, from, next) {
            loader.beforeRouteUpdate(`/spa/cart/${to.params.server}`, to, from, next, this);
        },
        methods: {
            remove(id) {
                this.items.forEach((item, index) => {
                    if (item.product.id === id) {
                        this.items.splice(index, 1);
                    }
                })
            },
            /**
             * Recalculate total sum.
             *
             * @param old Number
             * @param newVal Number
             */
            resum(old, newVal) {
                this.total -= old;
                this.total += newVal;
            },
            recount(id, newVal) {
                if (newVal >= 0) {
                    this.purchaseItems[id] = newVal;
                } else {
                    this.purchaseItems.splice(id, 1);
                }
            },
            clear() {
                this.items = [];
                this.$store.commit('setCartAmount', 0);
            },
            purchase() {
                this.loadingPurchaseBtn = true;
                this.$axios.post(`/spa/cart/${this.$route.params.server}`, {
                    items: this.purchaseItems
                })
                    .then(response => {
                        const data = response.data;
                        if (data.status === 'success') {
                            this.clear();
                            if (data.quick) {
                                this.$store.commit('setBalance', data.newBalance);
                            } else {
                                this.$router.push({name: 'frontend.shop.payment', params: {purchase: data.purchaseId}});
                            }
                        }
                        this.loadingPurchaseBtn = false;
                    })
                    .catch(err => {
                        this.loadingPurchaseBtn = false;
                    });
            },
            setData(response) {
                const data = response.data;

                this.items = data.cart;
                this.reCaptchaKey = data.captchaKey;
                this.$store.commit('setServer', data.currentServer);
            }
        },
        components: {
            'cart-item': CartItem,
            'purchase-dialog': PurchaseDialog
        }
    }
</script>
