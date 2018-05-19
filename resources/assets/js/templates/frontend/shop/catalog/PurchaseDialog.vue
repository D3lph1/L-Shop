<template>
    <v-dialog persistent v-model="dialog" max-width="400">
        <v-card>
            <v-card-title class="headline">
                {{ $t('content.frontend.shop.catalog.purchase.title', {product: name}) }}
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <div class="flex-wrapper" v-if="!(isPermgroup && stack === 0)">
                    <v-text-field
                            class="pt-1"
                            :prefix="amountLabel()"
                            prepend-icon="drag_indicator"
                            v-model="amount"
                    ></v-text-field>
                    <v-btn class="my-0" color="red" icon flat @click="decrement" :disabled="amount <= stack">
                        <v-icon>remove</v-icon>
                    </v-btn>
                    <v-btn class="ma-0" color="green" icon flat @click="increment">
                        <v-icon>add</v-icon>
                    </v-btn>
                </div>
                <div class="flex-wrapper" v-if="!$store.getters.isAuth">
                    <v-text-field
                            prepend-icon="persons"
                            :prefix="$t('common.username') + ':'"
                            :hint="$t('content.frontend.shop.catalog.purchase.username_description')"
                            v-model="username"
                    ></v-text-field>
                </div>
                <h2 class="headline">
                    {{ $t('content.frontend.shop.catalog.purchase.cost', {cost, currency: $store.state.shop.currency.html}) }}
                </h2>
                <v-alert class="mt-4" type="info" :value="notEnough">
                    <span>{{ $t('content.frontend.shop.catalog.purchase.not_enough') }}</span>
                </v-alert>
                <v-alert class="mt-4" type="info" :value="notAuthAlert">
                    <span>{{ $t('content.frontend.shop.catalog.purchase.not_auth') }}</span>
                </v-alert>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                        flat
                        round
                        color="red"
                        @click="$emit('hide')"
                >
                    {{ $t('common.cancel') }}
                </v-btn>
                <v-btn
                        color="green"
                        flat
                        round
                        @click.native="purchase"
                        :loading="loadingPurchaseBtn"
                >
                    {{ $t('content.frontend.shop.catalog.purchase.purchase') }}
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    export default {
        props: {
            dialog: {
                required: true,
                type: Boolean
            },
            id: {
                required: true,
                type: Number
            },
            name: {
                required: true,
                type: String
            },
            price: {
                required: true,
                type: Number
            },
            stack: {
                required: true,
                type: Number
            },
            isItem: {
                required: true,
                type: Boolean
            },
            isPermgroup: {
                required: true,
                type: Boolean
            }
        },
        data() {
            return {
                username: '',
                amount: this.stack,
                cost: this.price,
                loadingPurchaseBtn: false
            }
        },
        watch: {
            /**
             * Initialize a amount with a value from the store.
             */
            stack(val) {
                this.amount = val;
            },
            /**
             * Initialize a cost with a value from the store
             */
            price(val) {
                this.cost = val;
            }
        },
        computed: {
            notEnough() {
                if (this.notAuthAlert) {
                    return false
                }

                return this.cost > this.$store.state.auth.user.balance;
            },
            notAuthAlert() {
                return !this.$store.getters.isAuth;
            }
        },
        methods: {
            /**
             * Executes the order, by sending a request to the server.
             */
            purchase() {
                this.recount();
                /*
                if (!captcha.getToken()) {
                    msg.warning(this.$t('msg.captcha_required'));
                    return;
                }
                */
                this.loadingPurchaseBtn = true;
                this.$axios.post('/spa/catalog/purchase', {
                    username: this.username,
                    product: this.id,
                    amount: this.amount
                })
                    .then((response) => {
                        this.loadingPurchaseBtn = false;
                        const data = response.data;
                        if (data.status === 'success') {
                            if (data.quick) {
                                this.$store.commit('setBalance', data.newBalance);
                            } else {
                                this.$router.push({name: 'frontend.shop.payment', params: {purchase: data.purchaseId}});
                            }
                        }
                        this.$emit('hide');
                    });
            },
            /**
             * Increases the amount of the product by 1 stack.
             */
            increment() {
                this.amount += this.stack;
                this.recount();
            },
            /**
             * Decrements the amount of the product by 1 stack.
             */
            decrement() {
                this.amount -= this.stack;
                this.recount();
            },
            /**
             * Recalculates the quantity of goods, producing normalization. Valid is considered
             * to be an amount that condition (amount % stack == 0) condition. If an incorrect
             * quantity of goods is entered, it is normalized, by rounding to the
             * nearest acceptable number.
             * For example:
             *      stack size: 16
             *      User input: 31
             *      Normalized count: 32
             * -----
             *      stack size: 16
             *      User input: -5
             *      Normalized count: 16
             */
            recount() {
                if (this.amount <= 0) {
                    this.amount = this.stack;
                    this.resum();
                    return;
                }
                if (this.amount % this.stack !== 0) {
                    let newAmount = Math.round(this.amount / this.stack) * this.stack;
                    if (newAmount < this.stack) {
                        newAmount = this.stack;
                    }
                    if (newAmount > 0) {
                        this.amount = newAmount;
                    }
                }
                this.resum();
            },
            /**
             * Recalculates the amount of the order. The calculated property is not suitable, since
             * the amount should be recalculated only with a normalized amount of products.
             */
            resum() {
                this.cost = this.price * this.amount / this.stack;
            },
            amountLabel() {
                if (this.isItem) {
                    return $t('content.frontend.shop.catalog.purchase.amount');
                } else if (this.isPermgroup) {
                    return $t('content.frontend.shop.catalog.purchase.duration');
                }

                return '';
            }
        }
    }
</script>

<style lang="less" scoped>
    .flex-wrapper {
        display: flex;
        flex-wrap: nowrap;;
        align-items: flex-start;
    }
</style>
