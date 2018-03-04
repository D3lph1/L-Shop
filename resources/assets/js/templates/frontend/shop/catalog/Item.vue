<template>
    <v-flex xs12 sm12 md4 lg3>
        <v-card class="product-block">
            <div class="product-header title">
                <div class="product-name">{{ name }}</div>
                <div class="product-menu">
                    <v-menu bottom left>
                        <v-btn flat icon small slot="activator">
                            <v-icon>more_vert</v-icon>
                        </v-btn>
                        <v-list>
                            <v-list-tile @click="this.openAboutDialog">
                                <v-list-tile-title>{{ $t('content.frontend.shop.catalog.item.about') }}</v-list-tile-title>
                            </v-list-tile>
                            <v-list-tile v-if="productsCrudAccess" :to="{name: 'admin.products.edit', params: {product: id}}">
                                <v-list-tile-title>{{ $t('content.frontend.shop.catalog.item.go_to_product') }}</v-list-tile-title>
                            </v-list-tile>
                            <v-list-tile v-if="itemsCrudAccess" :to="{name: 'admin.items.edit', params: {item: itemId}}">
                                <v-list-tile-title>{{ $t('content.frontend.shop.catalog.item.go_to_item') }}</v-list-tile-title>
                            </v-list-tile>
                        </v-list>
                    </v-menu>
                </div>
            </div>
            <img :src="image" class="product-image" :alt="name">
            <p class="product-price subheading">{{ price }} <span v-html="$store.state.shop.currency.html"></span></p>
            <p class="product-count subheading">
                <span v-if="isItem">
                    {{ $t('content.frontend.shop.catalog.item.stack_item', {stack}) }}
                </span>
                <span v-else-if="isPermgroup">
                    <span v-if="stack === 0">
                        {{ $t('content.frontend.shop.catalog.item.stack_permgroup_forever') }}
                    </span>
                    <span v-else>
                        {{ $t('content.frontend.shop.catalog.item.stack_permgroup', {stack}) }}
                    </span>
                </span>
            </p>

            <v-btn block small color="secondary" :loading="loading" :disabled="alreadyInCart" @click="put">
                <v-icon left small>add_shopping_cart</v-icon>
                <span v-if="alreadyInCart">{{ $t('content.frontend.shop.catalog.item.already_in_cart') }}</span>
                <span v-else>{{ $t('content.frontend.shop.catalog.item.put_in_cart') }}</span>
            </v-btn>
            <v-btn block small color="primary" @click="openPurchaseDialog"><v-icon left small>attach_money</v-icon>
                {{ $t('content.frontend.shop.catalog.item.quick_purchase') }}
            </v-btn>
        </v-card>
    </v-flex>
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
            itemId: {
                required: true,
                type: Number
            },
            inCart: {
                required: true,
                type: Boolean
            },
            isItem: {
                required: true,
                type: Boolean
            },
            isPermgroup: {
                required: true,
                type: Boolean
            },
            productsCrudAccess: {
                required: true,
                type: Boolean
            },
            itemsCrudAccess: {
                required: true,
                type: Boolean
            }
        },
        data() {
            return {
                loading: false,
                alreadyInCart: this.inCart
            }
        },
        watch: {
            inCart(val) {
                this.alreadyInCart = val;
            }
        },
        methods: {
            put() {
                this.loading = true;
                this.$axios.post('/api/cart', {
                    _method: 'PUT',
                    product: this.id
                })
                    .then((response) => {
                        if (response.data.status === 'success') {
                            this.loading = false;
                            this.alreadyInCart = true;
                            this.$store.commit('setCartAmount', response.data.amount);
                        }
                    });
            },
            openPurchaseDialog() {
                this.$emit('purchase-dialog-opening', this.id);
            },
            openAboutDialog() {
                this.$emit('about-dialog-opening', this.id);
            }
        }
    }
</script>

<style lang="sass">
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
        .product-header
            margin-top: 7px
            word-wrap: break-word
            margin-bottom: 1.5rem
            font-weight: 400
            .product-name
                display: inline-block
                width: 170px
                word-wrap: break-word
            .product-menu
                position: absolute
                top: 5px
                right: 0
                display: inline-block
        .product-price
            margin-bottom: 0
        .product-count
            margin-bottom: .25rem
        button
            font-size: 12px
            margin-left: 0
</style>
