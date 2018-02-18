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
                                :name="product.item.name"
                                :image="product.item.image"
                                :price="product.price"
                                :stack="product.stack"
                        ></catalog-item>
                    </v-layout>

                    <div class="text-xs-center" v-if="paginator.last_page > 1">
                        <v-pagination class="mt-5" :length="paginator.last_page" v-model="page" :total-visible="7"></v-pagination>
                    </div>
                </v-tab-item>
                <v-alert v-if="products.length === 0" type="info" :value="true">
                    <div class="text-xs-center">Категория пуста</div>
                </v-alert>
            </v-tabs-items>
        </div>
        <v-alert v-else type="info" :value="true">
            <div class="text-xs-center">Категории отсутствуют</div>
        </v-alert>
    </div>
</template>

<script>
    import loader from './../../../../core/http/loader'
    import Header from './Header.vue'
    import Item from './Item.vue'

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
                logo: null,
                tab: null,
                page: 1,
                currentCategory: {},
                server: {
                    categories: []
                },
                paginator: [],
                products: []
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
                this.$router.push(buildUrl(this.$route.params.server, this.$route.params.category, val));
            }
        },
        methods: {
            setData(response) {
                const data = response.data;

                this.shopName = data.shopName;
                this.logo = data.logo;
                this.server = data.server;

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
                this.$router.push({
                    name: 'frontend.shop.catalog.category',
                    params: {
                        server: this.$route.params.server,
                        category: id
                    }
                });
            },
        },
        components: {
            'catalog-header': Header,
            'catalog-item': Item,
        }
    }
</script>
