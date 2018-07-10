<template>
    <v-card>
        <v-card-title>
            {{ $t('content.admin.items.list.title') }}
            <v-btn flat color="primary" small icon :to="{name: 'admin.items.add'}"><v-icon>add</v-icon></v-btn>
            <v-spacer></v-spacer>
            <v-text-field
                    append-icon="search"
                    :label="$t('content.admin.items.list.search')"
                    single-line
                    hide-details
                    v-model="search"
            ></v-text-field>
        </v-card-title>
        <v-data-table
                :headers="headers"
                :items="items"
                :pagination.sync="pagination"
                :total-items="totalItems"
                :loading="loading"
                :no-data-text="$t('content.admin.items.list.table.empty')"
                :rows-per-page-items="[25, 50, 100]"
                :rows-per-page-text="$t('common.table.rows_per_page')"
                class="elevation-1"
        >
            <template slot="pageText" slot-scope="{ pageStart, pageStop }">
                {{ pageStart }} - {{ pageStop }} {{ $t('common.table.of') }} {{ totalItems }}
            </template>

            <template slot="items" slot-scope="props">
                <td class="text-xs-center">{{ props.item.id }}</td>
                <td class="text-xs-center"><img :src="props.item.image" height="30" :alt="props.item.name"></td>
                <td class="text-xs-center">
                    {{ props.item.name }}
                    <v-enchanted class="cp" v-if="props.item.enchanted"></v-enchanted>
                </td>
                <td class="text-xs-center">{{ props.item.type }}</td>
                <td class="justify-center layout px-0">
                    <v-btn icon class="mx-0" :to="{name: 'admin.items.edit', params: {item: props.item.id}}">
                        <v-icon color="secondary">edit</v-icon>
                    </v-btn>
                    <v-btn icon class="mx-0" @click="deleteItem(props.item)">
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
                        text: $t('content.admin.items.list.table.headers.id'),
                        align: 'center',
                        sortable: true,
                        value: 'id'
                    },
                    {
                        text: $t('common.image'),
                        sortable: false,
                        align: 'center',
                    },
                    {
                        text: $t('content.admin.items.list.table.headers.name'),
                        align: 'center',
                        sortable: true,
                        value: 'name'
                    },
                    {
                        text: $t('common.type'),
                        align: 'center',
                        sortable: true,
                        value: 'type'
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

                    this.$router.replace({name: 'admin.items.list', query: query}, () => {
                        this.retrieveFromApi();
                    }, () => {
                        this.retrieveFromApi();
                    });
                },
                deep: true
            },
            search() {
                this.retrieveFromApi();
            }
        },
        methods: {
            retrieveFromApi() {
                this.loading = true;

                this.$axios.post('/spa/admin/items/list', {
                    page: this.$route.query.page,
                    per_page: this.$route.query.per_page,
                    order_by: this.$route.query.order_by,
                    descending: this.$route.query.descending,
                    search: this.search
                })
                    .then(response => {
                        this.setTable(response.data)
                    });
            },
            deleteItem(item) {
                if (confirm($t('content.admin.items.list.delete', {name: item.name}))) {
                    this.$axios.post('/spa/admin/items', {
                        _method: 'DELETE',
                        item: item.id
                    })
                        .then(response => {
                            if (response.data.status === 'success') {
                                this.items.forEach((each, index) => {
                                    if (each.id === item.id) {
                                        this.items.splice(index, 1);
                                    }
                                });
                            }
                        });
                }
            },
            setTable(data) {
                this.totalItems = data.paginator.total;
                this.items = data.items;

                this.loading = false;
            }
        }
    }
</script>
