<template>
    <div>
        <div id="cart-header" class="z-depth-1">
            <h1><i class="fa fa-shopping-cart fa-lg fa-left-big"></i>{{ $t('content.shop.cart.title') }}</h1>
        </div>
        <div v-if="cart.length !== 0 && this.$store.state.cart.amount !== 0" id="total">
            <div id="total-p">
                <div  v-if="!isAuth" class="md-form inline">
                    <i class="fa fa-user prefix"></i>
                    <input type="text" id="c-login" class="form-control">
                    <label for="c-login">{{ $t('content.shop.cart.username') }}</label>
                </div>
                <div class="inline">
                    {{ $t('content.shop.cart.total') }}
                    <span id="total-money"><span>{{ cost }}</span><span v-html="currency"></span></span>
                </div>
                <div v-html="captcha" class="mr-2 ml-2"></div>
                <button class="btn btn-warning btn-sm">
                    {{ $t('content.shop.cart.pay') }}
                    <i class="fa fa-arrow-right fa-right"></i>
                </button>
            </div>
        </div>
        <div id="cart-products">
            <div v-if="cart.length !== 0 && this.$store.state.cart.amount !== 0">
                <cart-item v-for="item in cart" :cart-item="item" :key="item.product.id" :route-remove="routeRemove" :currency="currency"></cart-item>
            </div>
            <h3 v-else>{{ $t('content.profile.cart.empty') }}</h3>
        </div>
    </div>
</template>

<script>
    import CartItem from './Item.vue'

    export default {
        props: ['isAuth', 'currency', 'cart', 'captcha', 'routeRemove'],
        computed: {
            cost() {
                return this.$store.state.cart.cost;
            }
        },
        components: {
            'cart-item': CartItem
        }
    }
</script>
