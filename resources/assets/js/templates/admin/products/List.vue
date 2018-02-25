<template>
    <v-card>
        <v-card-title>
            {{ $t('content.admin.products.list.title') }}
            <v-spacer></v-spacer>
            <v-text-field
                    append-icon="search"
                    :label="$t('content.admin.products.list.search')"
                    single-line
                    hide-details
                    v-model="search"
            ></v-text-field>
        </v-card-title>
        <v-data-table
                :headers="headers"
                :items="items"
                :search="search"
                :pagination.sync="pagination"
                :total-items="totalItems"
                :loading="loading"
                :no-data-text="$t('content.admin.products.list.table.empty')"
                :rows-per-page-items="[25, 50, 100]"
                :rows-per-page-text="$t('common.table.rows_per_page')"
                class="elevation-1"
        >
            <template slot="pageText" slot-scope="{ pageStart, pageStop }">
                {{ pageStart }} - {{ pageStop }} {{ $t('common.table.of') }} {{ totalItems }}
            </template>

            <template slot="items" slot-scope="props">
                <td class="text-xs-center">{{ props.item.id }}</td>
                <td class="text-xs-center"><img :src="props.item.item.image" height="30" :alt="props.item.item.name"></td>
                <td class="text-xs-center">{{ props.item.item.name }}</td>
                <td class="text-xs-center">{{ props.item.item.type }}</td>
                <td class="text-xs-center">{{ props.item.price }}</td>
                <td class="text-xs-center">{{ props.item.stack }}</td>
                <td class="justify-center layout px-0">
                    <v-btn icon class="mx-0">
                        <v-icon color="secondary">edit</v-icon>
                    </v-btn>
                </td>
            </template>
        </v-data-table>
    </v-card>
</template>

<script>
    export default {
        data() {
            return {
                search: '',
                totalItems: 0,
                items: [],
                loading: false,
                pagination: {},
                headers: [
                    {
                        text: $t('content.admin.products.list.table.headers.id'),
                        align: 'center',
                        sortable: true,
                        value: 'product.id'
                    },
                    {
                        text: $t('content.admin.products.list.table.headers.image'),
                        sortable: false,
                        align: 'center',
                    },
                    {
                        text: $t('content.admin.products.list.table.headers.item'),
                        align: 'center',
                        sortable: true,
                        value: 'item.name'
                    },
                    {
                        text: $t('content.admin.products.list.table.headers.type'),
                        align: 'center',
                        sortable: true,
                        value: 'item.type'
                    },
                    {
                        text: $t('content.admin.products.list.table.headers.price'),
                        align: 'center',
                        sortable: true,
                        value: 'product.price'
                    },
                    {
                        text: $t('content.admin.products.list.table.headers.stack'),
                        align: 'center',
                        sortable: true,
                        value: 'product.stack'
                    },
                    {
                        text: $t('common.actions'),
                        align: 'center',
                        sortable: false
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
                    if (this.pagination.rowsPerPage) {
                        query.per_page = this.pagination.rowsPerPage;
                    }
                    if (this.pagination.sortBy) {
                        query.order_by = this.pagination.sortBy;
                    }
                    if (this.pagination.descending !== null) {
                        query.descending = this.pagination.descending;
                    }

                    this.$router.replace({name: 'admin.products.list', query: query}, () => {
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

                this.$axios.post('/api/admin/products/list', {
                    page: this.$route.query.page,
                    per_page: this.$route.query.per_page,
                    order_by: this.$route.query.order_by,
                    descending: this.$route.query.descending,
                    search: this.search
                })
                    .then((response) => {
                        this.setTable(response.data)
                    });
            },
            setTable(data) {
                this.totalItems = data.paginator.total;
                this.items = data.products;

                this.loading = false;
            }
        }
    }
</script>
