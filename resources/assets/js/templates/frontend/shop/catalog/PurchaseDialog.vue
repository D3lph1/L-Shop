<template>
    <v-layout row justify-center>
        <v-dialog v-model="dialog" persistent max-width="500px">
            <v-card>
                <v-card-title>
                    <span class="headline">{{ $t('content.frontend.shop.catalog.purchase.title', {product: name}) }}</span>
                </v-card-title>
                <v-card-text>
                    <v-container grid-list-md>
                        <v-layout wrap>
                            <v-flex xs12 v-if="!$store.getters.isAuth">
                                <v-text-field
                                        class="centered"
                                        :label="$t('common.username')"
                                        :hint="$t('content.frontend.shop.catalog.purchase.username_description')"
                                        v-model="username"
                                ></v-text-field>
                            </v-flex>
                            <v-flex xs12 v-if="!(isPermgroup && stack === 0)">
                                <v-text-field
                                        type="number"
                                        class="centered no-spinners"
                                        :label="amountLabel()"
                                        v-model="amount"
                                        @blur="recount"
                                ></v-text-field>
                                <div class="text-xs-center">
                                    <v-btn color="primary" small @click="decrement" :disabled="amount <= stack"><v-icon>remove</v-icon></v-btn>
                                    <v-btn color="primary" small @click="increment"><v-icon>add</v-icon></v-btn>
                                </div>
                            </v-flex>
                            <v-flex class="text-xs-center mt-2" xs12>
                                <p class="title fw400" v-html="$t('content.frontend.shop.catalog.purchase.cost', {cost, currency: $store.state.shop.currency.html})"></p>
                            </v-flex>
                            <v-flex class="mt-2" xs12>
                                <v-alert type="info" :value="notEnough">{{ $t('content.frontend.shop.catalog.purchase.not_enough') }}</v-alert>
                            </v-flex>
                            <v-flex class="mt-2" xs12>
                                <v-alert type="info" :value="notAuthAlert">{{ $t('content.frontend.shop.catalog.purchase.not_auth') }}</v-alert>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" flat @click.native="$emit('close')">{{ $t('common.cancel') }}</v-btn>
                    <v-btn color="blue darken-1" flat @click.native="purchase" :loading="disabledBtn">{{ $t('content.frontend.shop.catalog.purchase.purchase') }}</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-layout>
</template>

<script>
    export default {
        props: {
            dialog: {
                required: true,
                type: Boolean
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
                disabledBtn: false
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
                this.disabledBtn = true;
                axios.post(this.url, {
                    username: this.username,
                    amount: this.amount
                }).then((response) => {
                    //
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
