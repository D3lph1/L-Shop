<template>
    <v-layout align-center justify-center v-if="product !== null">
        <v-flex xs12 sm12 md10 lg8>
            <v-card>
                <v-card-title class="text-xs-center">
                    <h3>{{ $t('content.admin.products.edit.title') }}</h3>
                    <v-spacer></v-spacer>
                    <span class="caption" v-html="$t('common.unclear_docs', {link: 'https://github.com/D3lph1/L-shop/wiki'})"></span>
                </v-card-title>
                <v-card-text>
                    <v-select
                            :items="items"
                            item-text="name"
                            item-value="id"
                            :return-object="true"
                            v-model="item"
                            :label="$t('content.admin.products.add.item')"
                            :prepend-icon="isItem ? 'beach_access' : (isPermgroup ? 'turned_in_not' : '')"
                    >
                        <template slot="item" slot-scope="data">
                            <v-list-tile-avatar :tile="true" size="35">
                                <img :src="data.item.image" class="br0">
                            </v-list-tile-avatar>
                            <v-list-tile-content>
                                <v-list-tile-title v-html="data.item.name"></v-list-tile-title>
                            </v-list-tile-content>
                        </template>
                    </v-select>
                    <v-select
                            :items="servers"
                            item-text="name"
                            item-value="id"
                            :return-object="true"
                            v-model="server"
                            :rules="[validateCategories]"
                            :label="$t('content.admin.products.add.server')"
                            prepend-icon="storage"
                    >
                    </v-select>
                    <v-select
                            v-show="server !== null && server.categories.length !== 0"
                            :items="categories"
                            item-text="name"
                            item-value="id"
                            :return-object="true"
                            v-model="category"
                            :label="$t('content.admin.products.add.category')"
                            prepend-icon="tab"
                    >
                    </v-select>
                    <v-text-field
                            type="number"
                            class="mt-4 no-spinners"
                            v-show="isItem && category && this.server.categories.length !== 0"
                            :label="$t('content.admin.products.add.item_stack')"
                            v-model="amount"
                            prepend-icon="plus_one"
                    ></v-text-field>
                    <v-switch
                            v-show="isPermgroup && category && this.server.categories.length !== 0"
                            color="secondary"
                            class="mt-4"
                            :label="$t('content.admin.products.add.forever')"
                            v-model="forever"
                    ></v-switch>
                    <v-text-field
                            type="number"
                            class="no-spinners"
                            v-show="isPermgroup && category && this.server.categories.length !== 0"
                            :label="$t('content.admin.products.add.permgroup_stack')"
                            :disabled="forever"
                            v-model="amount"
                            prepend-icon="timelapse"
                    ></v-text-field>
                    <v-text-field
                            type="number"
                            class="no-spinners"
                            :label="$t('content.admin.products.add.price')"
                            v-model="price"
                            prepend-icon="attach_money"
                    ></v-text-field>
                    <v-text-field
                            type="number"
                            class="no-spinners"
                            :label="$t('content.admin.products.add.sort_priority')"
                            v-model="sortPriority"
                            prepend-icon="sort"
                    ></v-text-field>
                    <v-switch
                            color="secondary"
                            :label="$t('content.admin.products.add.hide')"
                            v-model="hidden"
                    ></v-switch>
                </v-card-text>
                <v-card-actions>
                    <v-btn flat color="orange" :disabled="finishDisabled" @click="perform">{{ $t('content.admin.products.edit.finish') }}</v-btn>
                </v-card-actions>
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
    import loader from './../../../core/http/loader'

    export default {
        data() {
            return {
                item: null,
                items: [],
                server: null,
                servers: [],
                category: null,
                categories: [],
                product: null,
                isItem: false,
                isPermgroup: false,

                forever: false,
                amount: 0,
                price: 0,
                sortPriority: 0,
                hidden: false
            }
        },
        beforeRouteEnter (to, from, next) {
            loader.beforeRouteEnter(`/api/admin/products/edit/${to.params.product}`, to, from, next);
        },
        beforeRouteUpdate (to, from, next) {
            loader.beforeRouteUpdate(`/api/admin/products/edit/${to.params.product}`, to, from, next, this);
        },
        watch: {
            item(val) {
                if (val !== null) {
                    this.isItem = val.type.isItem;
                    this.isPermgroup = val.type.isPermgroup;
                }
            },
            server(val) {
                if (val !== null) {
                    this.categories = val.categories;
                }
            }
        },
        computed: {
            finishDisabled() {
                return this.item === null || this.item === '' ||
                    this.server === null || this.server === '' ||
                    this.category === null || this.category === '' ||
                    (!this.forever && Number(this.amount) <= 0) ||
                    Number(this.price) <= 0 ||
                    this.server === null || this.server.categories.length === 0;
            }
        },
        methods: {
            validateCategories() {
                if (this.server !== null && this.server.categories.length === 0) {
                    return $t('content.admin.products.add.no_categories');
                }

                return true;
            },
            perform() {
                this.$axios.post(`/api/admin/products/edit/${this.product.id}`, {
                    item: this.item.id,
                    category: this.category.id,
                    stack: this.amount,
                    forever: this.forever,
                    price: this.price,
                    sort_priority: this.sortPriority,
                    hidden: this.hidden
                })
                    .then(response => {
                        if (response.data.status === 'success') {
                            this.$router.push({name: 'admin.products.list'});
                        }
                    });
            },
            setData(response) {
                const data = response.data;

                data.items.forEach(product => {
                    if (product.id === data.product.item.id) {
                        this.item = product;
                    }
                });
                data.servers.forEach(server => {
                    server.categories.forEach(category => {
                        if (category.id === data.product.category.id) {
                            this.server = server;
                            this.category = category;
                        }
                    });
                });

                this.items = data.items;
                this.servers = data.servers;
                this.product = data.product;
                this.isItem = data.product.item.type.isItem;
                this.isPermgroup = data.product.item.type.isPermgroup;
                this.forever = data.product.stack === 0;
                this.amount = data.product.stack;
                this.price = data.product.price;
                this.sortPriority = data.product.sort_priority;
                this.hidden = data.product.hidden;
            }
        }
    }
</script>
