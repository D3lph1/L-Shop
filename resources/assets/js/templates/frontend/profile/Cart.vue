<template>
    <v-card>
        <v-card-title>
            {{ $t('content.frontend.profile.cart.title') }}
            <v-spacer></v-spacer>
            <v-select
                    append-icon="storage"
                    :label="$t('common.server')"
                    single-line
                    v-model="pagination.server"
                    :items="servers"
                    item-value="id"
            ></v-select>
        </v-card-title>
        <v-data-table
                :headers="headers"
                :items="items"
                :pagination.sync="pagination"
                :total-items="totalItems"
                :loading="loading"
                :no-data-text="$t('content.frontend.profile.cart.table.empty')"
                :rows-per-page-items="[25]"
                :rows-per-page-text="$t('common.table.rows_per_page')"
                class="elevation-1"
        >
            <template slot="pageText" slot-scope="{ pageStart, pageStop }">
                {{ pageStart }} - {{ pageStop }} {{ $t('common.table.of') }} {{ totalItems }}
            </template>

            <template slot="items" slot-scope="props">
                <td class="text-xs-center"><img :src="props.item.item.image" height="30"></td>
                <td class="text-xs-center">{{ props.item.item.name }}</td>
                <td class="text-xs-center">{{ props.item.amount }}</td>
                <td class="text-xs-center">{{ props.item.product.server }}</td>
            </template>
        </v-data-table>
    </v-card>
</template>

<script>
    export default {
        data() {
            return {
                servers: [],
                totalItems: 0,
                items: [],
                loading: false,
                pagination: {
                    page: this.$route.query.page ? this.$route.query.page : 1,
                    sortBy: this.$route.query.order_by ? this.$route.query.order_by : 'distribution.id',
                    descending: this.$route.query.descending === 'true',
                    server: this.$route.query.server ? parseInt(this.$route.query.server) : null
                },
                headers: [
                    {
                        text: $t('common.image'),
                        align: 'center',
                        sortable: false,
                        value: 'item.image'
                    },
                    {
                        text: $t('content.frontend.profile.cart.table.headers.name'),
                        align: 'center',
                        sortable: true,
                        value: 'item.name'
                    },
                    {
                        text: $t('content.frontend.profile.cart.table.headers.amount'),
                        align: 'center',
                        sortable: true,
                        value: 'purchaseItem.amount'
                    },
                    {
                        text: $t('common.server'),
                        align: 'center',
                        sortable: true,
                        value: 'server.name'
                    }
                ]
            }
        },
        watch: {
            pagination: {
                handler () {
                    let query = {};
                    if (this.pagination.page) {
                        query.page = this.pagination.page;
                    }
                    if (this.pagination.sortBy) {
                        query.order_by = this.pagination.sortBy;
                    }
                    if (this.pagination.descending !== null) {
                        query.descending = this.pagination.descending;
                    }
                    if (this.pagination.server !== null) {
                        query.server = this.pagination.server;
                    }

                    this.$router.replace({name: 'frontend.profile.cart', query: query}, () => {
                        this.retrieveFromApi();
                    }, () => {
                        this.retrieveFromApi();
                    });
                },
                deep: true
            }
        },
        methods: {
            retrieveFromApi() {
                this.loading = true;

                this.$axios.post('/api/profile/cart', {
                    page: this.$route.query.page,
                    order_by: this.$route.query.order_by,
                    descending: this.$route.query.descending,
                    server: this.$route.query.server
                })
                    .then(response => {
                        this.setTable(response.data)
                    });
            },
            setTable(data) {
                this.totalItems = data.paginator.total;
                this.items = data.items;
                this.servers = data.servers;
                // Prepend 'Any server' element in array.
                this.servers.unshift({text: $t('content.frontend.profile.cart.any_server'), id: null});

                this.loading = false;
            },
        }
    }
</script>
