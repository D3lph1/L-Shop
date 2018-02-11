<template>
    <div v-if="visible" class="c-product z-depth-1">
        <div class="c-1-info">
            <p class="c-p-name">{{ cartItem.product.item.name }}</p>

            <img :src="cartItem.product.item.image" :alt="cartItem.product.item.name" class="product-image image-fluid">

            <button class="btn danger-color btn-sm btn-block" :disabled="disabledBtn" @click="remove">
                <i class="fa fa-times fa-left"></i>
                {{ $t('content.shop.cart.item.remove') }}
            </button>

        </div>
        <div class="c-2-info">
            <div v-if="cartItem.product.stack !== 0">
                <p class="c-p-count">
                    <span v-if="cartItem.product.item.type.isItem">
                        {{ $t('content.shop.cart.item.count') }}
                    </span>
                    <span v-else-if="cartItem.product.item.type.isPermgroup">
                        {{ $t('content.shop.cart.item.duration') }}
                    </span>
                </p>
                <div class="md-form">
                    <input v-model="amount" @blur="recount" type="number" class="form-control text-center c-p-count-input no-spinners">
                </div>

                <div class="c-p-cbuttons">
                    <button class="btn btn-warning btn-sm cart-minus-btn" @click="decrement"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-warning btn-sm cart-plus-btn" @click="increment"><i class="fa fa-plus"></i></button>
                </div>
            </div>
            <div v-else>
                <div class="alert alert-info alerts">
                    {{ $t('content.shop.cart.item.forever') }}
                </div>
            </div>

            <p class="c-p-pay">{{ $t('content.shop.cart.item.total') }}</p>
            <p class="c-p-pay-money"><span>{{ cost }}</span> <span v-html="currency"></span></p>

        </div>
    </div>
</template>

<script>
    export default {
        props: ['cartItem', 'currency', 'routeRemove'],
        data() {
            return {
                amount: this.cartItem.product.stack,
                cost: this.cartItem.product.price,
                disabledBtn: false,
                visible: true
            }
        },
        mounted() {
            this.$store.commit('addCartCost', this.cost);
        },
        methods: {
            /**
             * Increases the amount of the product by 1 stack.
             */
            increment() {
                this.amount += this.cartItem.product.stack;
                this.recount();
            },
            /**
             * Decrements the amount of the product by 1 stack.
             */
            decrement() {
                this.amount -= this.cartItem.product.stack;
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
                    this.amount = this.cartItem.product.stack;
                    this.resum();

                    return;
                }

                if (this.amount % this.cartItem.product.stack !== 0) {
                    let newAmount = Math.round(this.amount / this.cartItem.product.stack) * this.cartItem.product.stack;
                    if (newAmount < this.cartItem.product.stack) {
                        newAmount = this.cartItem.product.stack;
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
                this.$store.commit('subCartCost', this.cost);
                this.cost = this.cartItem.product.price * this.amount / this.cartItem.product.stack;
                this.$store.commit('addCartCost', this.cost);
            },
            remove() {
                this.disabledBtn = true;
                axios.post(this.routeRemove, {
                    _method: 'DELETE',
                    product: this.cartItem.product.id
                })
                    .then((response) => {
                        if (response.data.status === 'success') {
                            this.visible = false;
                            this.$store.commit('removeFromCart');
                            this.$store.commit('subCartCost', this.cost);
                        }
                        this.disabledBtn = false;
                    });
            }
        }
    }
</script>
