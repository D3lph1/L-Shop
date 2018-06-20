<template>
    <v-card hover class="shop-product">
        <v-card-title class="product-title pa-2">
            <span class="subheading">{{ name }}</span>
            <v-spacer></v-spacer>
            <v-btn
                    class="mr-1"
                    icon
                    flat
                    color="red"
                    :loading="removeBtnLoading"
                    @click="remove"
            >
                <v-icon>close</v-icon>
            </v-btn>
        </v-card-title>

        <div class="product-img" :src="image" :alt="name">
            <img :src="image">
        </div>

        <v-card-title class="product-price py-2 px-3">
            <div class="mb-0">
                <v-text-field
                        type="number"
                        class="pt-1 no-spinners"
                        :prefix="amountLabel()"
                        :value="amount"
                        :disabled="isPermgroup && stack === 0"
                        v-model="amount"
                        @blur="recount"
                ></v-text-field>
            </div>
            <p class="subheading my-0">
                <span v-html="$t('content.frontend.shop.cart.item.cost', {cost, currency: $store.state.shop.currency.html})"></span>
            </p>
        </v-card-title>

        <v-divider></v-divider>

        <v-card-actions class="product-footer">
            <v-tooltip v-if="isPermgroup && stack === 0" bottom>
                <v-btn
                        class="product-btn"
                        icon
                        flat
                        color="primary"
                        slot="activator"
                >
                    <v-icon>alarm</v-icon>
                </v-btn>
                <span>{{ $t('content.frontend.shop.cart.item.forever') }}</span>
            </v-tooltip>
            <v-tooltip bottom v-if="enchantments.length !== 0">
                <v-btn class="product-btn"
                       icon
                       flat
                       color="purple lighten-1"
                       slot="activator"
                >
                    <v-icon>flash_on</v-icon>
                </v-btn>
                <span>{{ $t('content.frontend.shop.catalog.item.enchanted') }}</span>
            </v-tooltip>
            <v-spacer></v-spacer>
            <div v-if="isItem || (isPermgroup && stack !== 0)">
                <v-spacer></v-spacer>
                <v-btn
                        icon
                        flat
                        outline
                        color="red"
                        @click="decrement"
                        :disabled="amount <= stack"
                >
                    <v-icon>remove</v-icon>
                </v-btn>

                <v-btn
                        class="mr-2"
                        icon
                        flat
                        outline
                        color="green"
                        @click="increment"
                >
                    <v-icon>add</v-icon>
                </v-btn>
            </div>
        </v-card-actions>
    </v-card>
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
            },
            enchantments: {
                required: true,
                type: Array
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
        /**
         * Init component.
         */
        mounted() {
            this.$emit('recount', this.id, this.amount);
            this.$emit('resum', 0, this.cost);
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
                const old = this.cost;
                this.cost = this.price * this.amount / this.stack;
                this.$emit('recount', this.id, this.amount);
                this.$emit('resum', old, this.cost)
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
                            this.$store.commit('subCartAmount', 1);
                            // Emit event to notify parent about deleting element.
                            this.$emit('recount', this.id, -1);
                            // Emit event to decrement cost of deletable product from total sum.
                            this.$emit('resum', this.cost, 0);
                            // Emit event to remove product from cart.
                            this.$emit('remove', this.id);
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

<style lang="less">
    .shop-product {
        width: 100%;
        max-width: 250px;
        .product-title {
            flex-wrap: nowrap;
            .product-menu-btn {
                margin: 0;
            }
        }
        .product-img {
            padding: 0 40px;
            img {
                display: block;
                width: 100%;
            }
        }
        .product-footer {
            display: flex;
            align-items: center;
            background-color: #f5f5f5;
        }
    }
</style>
