<template>
    <div class="modal fade" id="catalog-to-buy-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title w-100">
                        {{ $t('content.shop.catalog.fast_buy_modal.title') }} ({{ this.$store.state.purchasable.name }})
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="md-form">
                        <input v-if="!this.$store.state.isAuth" v-model="username" type="text" class="form-control text-center" :placeholder="$t('content.shop.catalog.fast_buy_modal.username')">
                        <input v-model="count" @blur="recount" type="number" class="form-control text-center no-spinners">

                        <div class="text-center" id="catalog-to-buy-cbuttons">
                            <button class="btn btn-warning btn-sm" @click="decrement"><i class="fa fa-minus"></i></button>
                            <button class="btn btn-warning btn-sm" @click="increment"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="alert alert-info">
                        <span v-if="this.$store.state.isAuth">
                            <span v-html="$t('content.shop.catalog.fast_buy_modal.auth', {sum, currency})"></span>
                        </span>
                        <span v-else>
                            <span v-html="$t('content.shop.catalog.fast_buy_modal.guest', {sum, currency})"></span>
                        </span>
                    </div>

                    <div v-html="captcha"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" :disabled="disabledBtn" @click="purchase">{{ $t('content.shop.catalog.fast_buy_modal.next_btn') }}</button>
                    <button type="button" class="btn btn-outline-warning" data-dismiss="modal">{{ $t('content.shop.catalog.fast_buy_modal.cancel_btn') }}</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Url from './../../common/url';

    export default {
        props: ['currency', 'captcha'],
        data() {
            return {
                username: '',
                count: 0,
                sum: 0,
                disabledBtn: false
            }
        },
        computed: {
            stack() {
                return this.$store.state.purchasable.stack;
            },
            price() {
                return this.$store.state.purchasable.price;
            },
            url() {
                return this.$store.state.purchasable.url;
            },
        },
        watch: {
            /**
             * Initialize a count with a value from the store.
             */
            stack(val) {
                this.count = val;
            },
            /**
             * Initialize a sum with a value from the store
             */
            price(val) {
                this.sum = val;
            }
        },
        methods: {
            /**
             * Executes the order, by sending a request to the server.
             */
            purchase() {
                this.recount();

                if (!captcha.getToken()) {
                    msg.warning(this.$t('msg.captcha_required'));

                    return;
                }
                this.disabledBtn = true;

                axios.post(this.url, {
                    username: this.username,
                    count: this.count,
                    captcha: captcha.getToken()
                }).then((response) => {
                    response = response.data;
                    grecaptcha.reset();
                    if (response.status === 'success') {
                        if (response.quick) {
                            msg.call(response.message.type, response.message.text);
                            $('#catalog-to-buy-modal').modal('hide');


                            this.$store.commit('setBalance', response.new_balance);
                        } else {
                            Url.redirect(response.redirect);
                        }
                    }
                    this.disabledBtn = false;
                });
            },
            /**
             * Increases the amount of the product by 1 stack.
             */
            increment() {
                this.count += this.stack;
                this.recount();
                this.resum();
            },
            /**
             * Decrements the amount of the product by 1 stack.
             */
            decrement() {
                this.count -= this.stack;
                this.recount();
                this.resum();
            },
            /**
             * Recalculates the quantity of goods, producing normalization. Valid is considered
             * to be an amount that condition (count % stack == 0) condition. If an incorrect
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
                if (this.count <= 0) {
                    this.count = this.stack;
                    this.resum();

                    return;
                }

                if (this.count % this.stack !== 0) {
                    const newCount = Math.round(this.count / this.stack) * this.stack;

                    if (newCount > 0) {
                        this.count = newCount;
                    }
                }

                this.resum();
            },
            /**
             * Recalculates the amount of the order. The calculated property is not suitable, since
             * the amount should be recalculated only with a normalized amount of products.
             */
            resum() {
                this.sum = this.price * this.count / this.stack;
            }
        }
    }
</script>