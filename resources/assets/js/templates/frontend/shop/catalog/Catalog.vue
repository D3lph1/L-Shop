<template>
    <div>
        <catalog-header :shop-name="shopName" :logo="logo"></catalog-header>
        <div v-if="server.categories.length !== 0">
            <v-tabs
                    centered
                    color="primary"
                    slot="extension"
                    slider-color="secondary"
                    v-model="tab"
                    grow
                    show-arrows
                    class="mb-3"
                    dark
            >
                <v-tab v-for="category in server.categories" :key="category.id" @click="changeCategory(category.id)">
                    {{ category.name }}
                </v-tab>
            </v-tabs>
            <v-tabs-items v-model="tab">
                <v-tab-item v-for="category in server.categories" :key="category.id">
                    <v-layout align-center justify-center wrap>
                        <catalog-item
                                v-for="(product, index) in products"
                                :key="index"
                                :id="product.id"
                                :name="product.item.name"
                                :image="product.item.image"
                                :price="product.price"
                                :stack="product.stack"
                                :item-id="product.item.id"
                                :in-cart="product.inCart"
                                :is-item="product.item.isItem"
                                :is-permgroup="product.item.isPermgroup"
                                :products-crud-access="productsCrudAccess"
                                :items-crud-access="itemsCrudAccess"
                                :enchantments="product.item.enchantments"
                                @purchase-dialog-opening="openPurchaseDialog"
                                @about-dialog-opening="openAboutDialog"
                                v-if="!loading"
                        ></catalog-item>
                    </v-layout>

                    <div class="text-xs-center" v-if="paginator.last_page > 1 && !loading">
                        <v-pagination
                                class="mt-5"
                                :length="paginator.last_page"
                                v-model="page"
                                :total-visible="7"
                                :disabled="paginationDisabled"
                        ></v-pagination>
                    </div>
                </v-tab-item>

                <div class="text-xs-center">
                    <v-progress-circular indeterminate color="primary" v-if="loading"></v-progress-circular>
                </div>

                <v-alert v-if="products.length === 0" type="info" outline :value="true">
                    <div class="text-xs-center">{{ $t('content.frontend.shop.catalog.empty_category') }}</div>
                </v-alert>
            </v-tabs-items>
        </div>
        <v-alert v-else type="info" outline :value="true">
            <div class="text-xs-center">{{ $t('content.frontend.shop.catalog.categories_does_not_exists') }}</div>
        </v-alert>

        <purchase-dialog
                v-if="purchase.dialog"
                :dialog="purchase.dialog"
                :id="purchasableProduct.id"
                :name="purchasableProduct.item.name"
                :price="purchasableProduct.price"
                :stack="purchasableProduct.stack"
                :is-item="purchasableProduct.item.isItem"
                :is-permgroup="purchasableProduct.item.isPermgroup"
                @close="closePurchaseDialog"
        ></purchase-dialog>

        <about-dialog
                v-if="about.dialog"
                :dialog="about.dialog"
                :name="aboutableProduct.item.name"
                :description="aboutableProduct.item.description"
                :image="aboutableProduct.item.image"
                :is-item="aboutableProduct.item.isItem"
                :is-permgroup="aboutableProduct.item.isPermgroup"
                :enchantments="aboutableProduct.item.enchantments"
                @close="closeAboutDialog"
        ></about-dialog>
    </div>
</template>

<script>
    import loader from './../../../../core/http/loader'
    import Header from './Header.vue'
    import Item from './Item.vue'
    import PurchaseDialog from './PurchaseDialog.vue'
    import AboutDialog from './AboutDialog.vue'

    function buildUrlApi(server, category, page) {
        return '/api' + buildUrl(server, category, page);
    }
    function buildUrl(server, category, page) {
        return `/catalog/${server}${category ? `/${category}` : ''}${typeof page !== 'undefined' ? `?page=${page}` : ''}`;
    }

    export default {
        data() {
            return {
                shopName: null,
                // URL of the shop logo.
                logo: null,
                // The current active tab of the v-tabs component.
                tab: null,
                // Current page of pagination.
                page: 1,
                currentCategory: {},
                server: {
                    // List of available categories for this server.
                    categories: []
                },
                // It stores information for paginating content, such as the current page,
                // the total number of pages, the URL of the previous and next page, and so on.
                paginator: {},
                // The variable stores an array of goods for the current page of the selected category.
                products: [],
                // This flag is used to hide items on tabs and to show the download indicator
                // when changing tabs.
                loading: false,
                // This flag is used to block the pagination component during the download of
                // products from a new page.
                paginationDisabled: false,

                purchase: {
                    dialog: false,
                    product: null
                },

                about: {
                    dialog: false,
                    product: null
                },

                productsCrudAccess: false,
                itemsCrudAccess: false,
            }
        },
        beforeRouteEnter(to, from, next) {
            loader.beforeRouteEnter(buildUrlApi(to.params.server, to.params.category, to.query.page), to, from, next);
        },
        beforeRouteUpdate(to, from, next) {
            loader.beforeRouteUpdate(buildUrlApi(to.params.server, to.params.category, to.query.page), to, from, next, this);
        },
        watch: {
            page(val) {
                this.paginationDisabled = true;
                this.$router.push(buildUrl(this.$route.params.server, this.$route.params.category, val),
                    () => {
                        this.paginationDisabled = false;
                    },
                    () => {
                        this.paginationDisabled = false;
                    });
            }
        },
        computed: {
            purchasableProduct() {
                return this.productById(this.purchase.product);
            },
            aboutableProduct() {
                return this.productById(this.about.product);
            }
        },
        methods: {
            setData(response) {
                const data = response.data;

                this.shopName = data.shopName;
                this.logo = data.logo;
                this.server = data.server;
                this.productsCrudAccess = data.productsCrudAccess;
                this.itemsCrudAccess = data.itemsCrudAccess;

                this.$store.commit('setServer', data.currentServer);

                if (data.currentCategory !== null) {
                    this.currentCategory = data.currentCategory;
                    this.model = data.currentCategory.id;

                    // In the next cycle, the current tab is set. Tab numeration starts at 0.
                    for (let i = 0; i < data.server.categories.length; i++) {
                        if (data.server.categories[i].id === data.currentCategory.id) {
                            this.tab = String(i);
                        }
                    }
                }
                if (data.paginator !== null) {
                    this.paginator = data.paginator;
                    this.products = data.products;
                    this.page = data.paginator.current_page;
                }
            },
            changeCategory(id) {
                this.loading = true;
                this.$router.push({
                    name: 'frontend.shop.catalog.category',
                    params: {
                        server: this.$route.params.server,
                        category: id
                    }
                }, () => {
                    this.loading = false;
                }, () => {
                    this.loading = false;
                });
            },
            openPurchaseDialog(id) {
                this.purchase.dialog = true;
                this.purchase.product = id;
            },
            closePurchaseDialog() {
                this.purchase.dialog = false;
            },
            openAboutDialog(id) {
                this.about.dialog = true;
                this.about.product = id;
            },
            closeAboutDialog() {
                this.about.dialog = false;
            },
            productById(id) {
                let item;
                this.products.forEach((each) => {
                    if (each.id === id) {
                        item = each;
                    }
                });

                return item;
            }
        },
        components: {
            'catalog-header': Header,
            'catalog-item': Item,
            'purchase-dialog': PurchaseDialog,
            'about-dialog': AboutDialog
        }
    }
</script>
