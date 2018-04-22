<template>
    <div v-if="visible" class="c-product z-depth-1">
        <v-card>
            <v-card-media class="product-cart-card">
                <div class="c-1-info">
                    <p class="c-p-name title mb-3 fw400">{{ name }}</p>

                    <img :src="image" :alt="name" class="product-image image-fluid">

                    <v-btn color="error" small block :loading="removeBtnLoading" @click="remove">
                        <v-icon left small>clear</v-icon>
                        {{ $t('content.frontend.shop.cart.item.remove') }}
                    </v-btn>

                </div>
                <div class="c-2-info">
                    <div v-if="stack !== 0">
                        <div class="md-form">
                            <v-text-field
                                    v-model="amount"
                                    @blur="recount"
                                    type="number"
                                    :label="amountLabel()"
                                    class="centered no-spinners"
                            >
                            </v-text-field>
                        </div>

                        <div class="c-p-cbuttons">
                            <v-btn color="primary" small @click="increment"><v-icon>add</v-icon></v-btn>
                            <v-btn color="primary" small @click="decrement" :disabled="amount <= stack"><v-icon>remove</v-icon></v-btn>
                        </div>
                    </div>
                    <div v-else>
                        {{ $t('content.frontend.shop.cart.item.forever') }}
                    </div>

                    <div class="body-2 mt-2">
                        <p class="c-p-pay">{{ $t('content.frontend.shop.cart.item.cost') }}</p>
                        <p class="c-p-pay-money"><span>{{ cost }}</span> <span v-html="$store.state.shop.currency.html"></span></p>
                    </div>
                </div>
            </v-card-media>
        </v-card>
    </div>
</template>

<script>
    export default {
        props: {
            id: {
                required: true,
                type: Number
            },
            name: {
                required: true,
                type: String
            },
            image: {
                required: true,
                type: String
            },
            price: {
                required: true,
                type: Number,
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
                visible: true,
                amount: this.stack,
                cost: this.price,
                removeBtnLoading: false
            }
        },
        methods: {
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
                //this.$store.commit('subCartCost', this.cost);
                this.cost = this.price * this.amount / this.stack;
                // this.$store.commit('addCartCost', this.cost);
            },
            remove() {
                this.removeBtnLoading = true;
                this.$axios.post('/spa/cart', {
                    _method: 'DELETE',
                    product: this.id
                })
                    .then((response) => {
                        if (response.data.status === 'success') {
                            this.visible = false;
                            // this.$store.commit('removeFromCart');
                            this.$store.commit('subCartAmount', 1);
                        }
                        this.removeBtnLoading = false;
                    });
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

<style lang="sass">
    .product-cart-card
            padding: 15px
</style>
