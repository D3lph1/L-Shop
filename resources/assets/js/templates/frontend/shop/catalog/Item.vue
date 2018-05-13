<template>
    <v-card hover class="shop-product">
        <v-card-title class="product-title">
            <span>{{ name }}</span>
            <v-spacer></v-spacer>
            <v-menu bottom left>
                <v-btn class="product-menu-btn" slot="activator" icon>
                    <v-icon>more_vert</v-icon>
                </v-btn>
                <v-list>
                    <v-list-tile @click="openAboutDialog">
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
        </v-card-title>

        <div class="product-img">
            <img :src="image">
        </div>

        <v-card-title class="product-price">
            <span>
                {{ price }}
                <span v-html="$store.state.shop.currency.html"></span>
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
            </span>
        </v-card-title>

        <v-divider></v-divider>

        <v-card-actions class="product-footer">
            <v-tooltip bottom>
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

            <v-tooltip bottom>
                <v-btn
                        class="product-btn"
                        icon
                        flat
                        outline
                        color="primary"
                        slot="activator"
                        :loading="loading"
                        :disabled="alreadyInCart"
                        @click="put"
                >
                    <v-icon>add_shopping_cart</v-icon>
                </v-btn>
                <span>
                    <span v-if="alreadyInCart">{{ $t('content.frontend.shop.catalog.item.already_in_cart') }}</span>
                    <span v-else>{{ $t('content.frontend.shop.catalog.item.put_in_cart') }}</span>
                </span>
            </v-tooltip>

            <v-tooltip bottom>
                <v-btn
                        class="product-btn"
                        icon
                        flat
                        outline
                        color="orange"
                        slot="activator"
                        @click.native.stop="openPurchaseDialog"
                >
                    <v-icon>attach_money</v-icon>
                </v-btn>
                <span>
                    {{ $t('content.frontend.shop.catalog.item.quick_purchase') }}
                </span>
            </v-tooltip>
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
            },
            enchantments: {
                required: true,
                type: Array
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
                this.$axios.post('/spa/cart', {
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

<style lang="less" scoped>
    .shop-product {
        width: 100%;
        max-width: 250px;
        .product-title {
            flex-wrap: nowrap;
            padding: 8px;
            .product-menu-btn {
                margin: 0;
            }
        }
        .product-img {
            padding: 15px;
            img {
                display: block;
                width: 100%;
            }
        }
        .product-price {
            padding: 8px;
        }
        .product-footer {
            display: flex;
            align-items: center;
            background-color: #f5f5f5;
        }
    }
</style>
