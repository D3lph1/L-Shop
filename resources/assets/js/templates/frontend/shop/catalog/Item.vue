<template>
    <v-flex xs12 sm12 md4 lg3>
        <v-card class="product-block">
            <p class="product-name headline">{{ name }}</p>
            <img :src="image" class="product-image" alt="">
            <p class="product-price subheading">{{ price }} $</p>
            <p class="product-count subheading">за {{ stack }} шт.</p>

            <v-btn block small color="secondary"><v-icon left small>add_shopping_cart</v-icon> В корзину</v-btn>
            <v-btn block small color="primary"><v-icon left small>attach_money</v-icon>Быстрая покупка</v-btn>
        </v-card>
    </v-flex>
</template>

<script>
    export default {
        props: {
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
            }
        }
    }
</script>

<style lang="sass" scoped>
    .product-block
        padding: .5rem
        margin: .5rem
        text-align: center
        flex-basis: 200px
        flex-grow: 1
        max-width: 450px
        .product-image
            max-width: 150px
            margin-bottom: .5rem
        .product-name
            word-wrap: break-word
            margin-bottom: .5rem
        .product-price
            margin-bottom: 0
        .product-count
            margin-bottom: .25rem
        button
            font-size: 12px
            margin-left: 0
</style>
