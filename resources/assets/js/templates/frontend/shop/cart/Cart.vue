<template>
    <v-layout align-center justify-center wrap>
        <div id="cart-products" v-if="items.length !== 0 && !isEmpty">
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
            ></cart-item>
        </div>
        <div class="headline" v-else>
            {{ $t('content.frontend.shop.cart.empty') }}
        </div>
    </v-layout>
</template>

<script>
    import loader from './../../../../core/http/loader'
    import CartItem from './Item.vue'

    export default {
        data() {
            return {
                items: [],
                isEmpty: false
            }
        },
        beforeRouteEnter(to, from, next) {
            loader.beforeRouteEnter(`/spa/cart/${to.params.server}`, to, from, next);
        },
        beforeRouteUpdate(to, from, next) {
            loader.beforeRouteUpdate(`/spa/cart/${to.params.server}`, to, from, next, this);
        },
        watch: {
            '$store.state.shop.cart.amount'(val) {
                this.isEmpty = val === 0;
            }
        },
        methods: {
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

<style lang="sass">
    #cart-products
        display: -webkit-flex
        display: -ms-flex
        display: flex
        flex-wrap: wrap
        justify-content: center
        .c-product
            display: -webkit-inline-flex
            //noinspection CssInvalidPropertyValue
            display: -ms-inline-flex
            display: inline-flex
            flex-basis: 320px
            padding: .5rem
            margin: .5rem
            text-align: center
            justify-content: center
            flex-grow: 1
            max-width: 500px
            p
                margin-bottom: .5rem
            button
                font-size: 12px
            .c-1-info
                flex-grow: 1
                padding: .5rem
                flex-basis: 150px
                justify-content: center
                text-align: center
                .c-p-name
                    max-width: 150px
                    margin: 0 auto .5rem auto
                    word-wrap: break-word
                img
                    max-width: 150px
                    margin-bottom: 1rem
            .c-2-info
                flex-grow: 1
                padding: .5rem
                flex-basis: 150px
                .md-form
                    margin-bottom: 0
                input
                    padding: 0
                    margin-bottom: 0
                .c-p-cbuttons
                    button
                        width: 2rem
                .c-p-pay-money
                    text-decoration: underline
                .c-p-pay-for
                    span
                        text-decoration: underline
</style>
