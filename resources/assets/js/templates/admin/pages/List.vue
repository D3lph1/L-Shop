<template>
    <v-card>
        <v-card-title>
            {{ $t('content.admin.pages.list.title') }}
            <v-btn flat color="primary" small icon :to="{name: 'admin.pages.add'}"><v-icon>add</v-icon></v-btn>
            <v-spacer></v-spacer>
            <v-text-field
                    append-icon="search"
                    :label="$t('content.admin.pages.list.search')"
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
                :no-data-text="$t('content.admin.pages.list.table.empty')"
                :rows-per-page-items="[25, 50, 100]"
                :rows-per-page-text="$t('common.table.rows_per_page')"
                class="elevation-1"
        >
            <template slot="pageText" slot-scope="{ pageStart, pageStop }">
                {{ pageStart }} - {{ pageStop }} {{ $t('common.table.of') }} {{ totalItems }}
            </template>

            <template slot="items" slot-scope="props">
                <td class="text-xs-center">{{ props.item.id }}</td>
                <td class="text-xs-center">{{ props.item.title }}</td>
                <td class="text-xs-center"><router-link :to="{name: 'frontend.page', params: {url: props.item.url}}">{{ props.item.link }}</router-link></td>
                <td class="justify-center layout px-0">
                    <v-btn icon class="mx-0" :to="{name: 'admin.pages.edit', params: {page: props.item.id}}">
                        <v-icon color="secondary">edit</v-icon>
                    </v-btn>
                    <v-btn icon class="mx-0" @click="deletePage(props.item)">
                        <v-icon color="pink">delete</v-icon>
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
                pagination: {
                    page: this.$route.query.page ? this.$route.query.page : 1,
                    rowsPerPage: this.$route.query.per_page ? parseInt(this.$route.query.per_page) : 25,
                    sortBy: this.$route.query.order_by ? this.$route.query.order_by : 'id',
                    descending: this.$route.query.descending === 'true',
                },
                headers: [
                    {
                        text: $t('content.admin.pages.list.table.headers.id'),
                        align: 'center',
                        sortable: true,
                        value: 'id'
                    },
                    {
                        text: $t('content.admin.pages.list.table.headers.title'),
                        align: 'center',
                        sortable: true,
                        value: 'title'
                    },
                    {
                        text: $t('content.admin.pages.list.table.headers.url'),
                        align: 'center',
                        sortable: true,
                        value: 'url'
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

                    this.$router.replace({name: 'admin.pages.list', query: query}, () => {
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

                this.$axios.post('/spa/admin/pages/list', {
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
            deletePage(page) {
                if (confirm($t('content.admin.pages.list.delete'))) {
                    this.$axios.post('/spa/admin/pages', {
                        _method: 'DELETE',
                        page: page.id
                    })
                        .then(response => {
                            if (response.data.status === 'success') {
                                this.items.forEach((each, index) => {
                                    if (each.id === page.id) {
                                        this.items.splice(index, 1);
                                    }
                                });
                        }
                    });
                }
            },
            setTable(data) {
                this.totalItems = data.paginator.total;
                this.items = data.pages;

                this.loading = false;
            }
        }
    }
</script>
