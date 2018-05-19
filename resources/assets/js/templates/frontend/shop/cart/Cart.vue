<template>
    <div>
        <div v-if="items.length !== 0">
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
                ></cart-item>
            </shop-grid>
        </div>
        <v-layout align-center justify-center class="headline" v-else>
            {{ $t('content.frontend.shop.cart.empty') }}
        </v-layout>
    </div>
</template>

<script>
    import loader from './../../../../core/http/loader'
    import CartItem from './Item.vue'

    export default {
        data() {
            return {
                items: []
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
            setData(response) {
                const data = response.data;

                this.items = data.cart;
                this.$store.commit('setServer', data.currentServer);
            }
        },
        components: {
            'cart-item': CartItem
        }
    }
</script>
