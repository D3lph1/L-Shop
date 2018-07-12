<template>
    <v-card>
        <v-card-title>
            {{ $t('content.admin.users.roles.roles_table.title') }}
            <v-btn flat color="primary" small icon @click="createRoleDialog = true"><v-icon>add</v-icon></v-btn>
            <create-role-dialog
                    :dialog="createRoleDialog"
                    @created="paginationHandler"
                    @close="closeCreateRoleDialog"
            ></create-role-dialog>
            <v-spacer></v-spacer>
            <v-text-field
                    append-icon="search"
                    :label="$t('content.admin.users.roles.roles_table.search')"
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
                :no-data-text="$t('content.admin.users.roles.roles_table.empty')"
                :rows-per-page-items="[25, 50, 100]"
                :rows-per-page-text="$t('common.table.rows_per_page')"
        >
            <template slot="items" slot-scope="props">
                <td class="text-xs-center">{{ props.item.id }}</td>
                <td class="text-xs-right">
                    <v-edit-dialog
                            :return-value.sync="props.item.name"
                            :cancel-text="$t('common.cancel')"
                            :save-text="$t('common.save')"
                            large
                            lazy
                    >
                        <div>{{ props.item.name }}</div>
                        <div slot="input" class="mt-3 title">{{ $t('content.admin.users.roles.roles_table.update_name') }}</div>
                        <v-text-field
                                slot="input"
                                v-model="props.item.name"
                                label="Edit"
                                single-line
                                counter="64"
                                autofocus
                                @change="update(props.item.id, props.item.name)"
                        ></v-text-field>
                    </v-edit-dialog>
                </td>
                <td class="text-xs-right">
                    <v-btn icon class="mx-0" @click="deleteRole(props.item)">
                        <v-icon color="pink">delete</v-icon>
                    </v-btn>
                </td>
            </template>
            <template slot="pageText" slot-scope="{ pageStart, pageStop }">
                {{ pageStart }} - {{ pageStop }} {{ $t('common.table.of') }} {{ totalItems }}
            </template>
        </v-data-table>
    </v-card>
</template>

<script>
    import CreateRoleDialog from './CreateRoleDialog.vue'

    export default {
        data () {
            return {
                search: '',
                totalItems: 0,
                items: [],
                loading: false,
                createRoleDialog: false,
                pagination: {
                    page: this.$route.query.roles_page ? this.$route.query.roles_page : 1,
                    rowsPerPage: this.$route.query.roles_per_page ? parseInt(this.$route.query.roles_per_page) : 25,
                    sortBy: this.$route.query.roles_order_by ? this.$route.query.roles_order_by : 'role.id',
                    descending: this.$route.query.roles_descending === 'true',
                },
                headers: [
                    {
                        text: $t('content.admin.users.roles.roles_table.headers.id'),
                        align: 'center',
                        sortable: true,
                        value: 'role.id'
                    },
                    {
                        text: $t('content.admin.users.roles.roles_table.headers.name'),
                        align: 'right',
                        sortable: true,
                        value: 'role.name'
                    },
                    {
                        text: $t('common.actions'),
                        align: 'right',
                        sortable: false,
                        value: 'actions'
                    }
                ]
            }
        },
        watch: {
            pagination: {
                handler() {
                    let query = {};
                    if (this.pagination.page) {
                        query.roles_page = this.pagination.page;
                    }
                    if (this.pagination.rowsPerPage) {
                        query.roles_per_page = this.pagination.rowsPerPage;
                    }
                    if (this.pagination.sortBy) {
                        query.roles_order_by = this.pagination.sortBy;
                    }
                    if (this.pagination.descending !== null) {
                        query.roles_descending = this.pagination.descending;
                    }

                    this.$router.replace({name: 'admin.users.roles', query: query}, () => {
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
        mounted() {
            this.paginationHandler();
        },
        methods: {
            update(id, name) {
                this.$axios.post(`/spa/admin/users/roles/${id}/update_name`, {
                    _method: 'PATCH',
                    name
                })
                    .then(response => {
                        this.$router.push({
                            query: {
                                roles_page: this.$route.query.roles_page,
                                roles_per_page: this.$route.query.roles_per_page,
                                roles_order_by: this.$route.query.roles_order_by,
                                roles_descending: this.$route.query.roles_descending,
                                update: Math.random()
                            }
                        });
                    });
            },
            deleteRole(role) {
                if (confirm($t('content.admin.users.roles.roles_table.delete'))) {
                    this.$axios.post(`/spa/admin/users/roles/${role.id}`, {
                        _method: 'DELETE'
                    })
                        .then(response => {
                            if (response.data.status === 'success') {
                                this.items.forEach((each, index) => {
                                    if (each.id === role.id) {
                                        this.items.splice(index, 1);
                                    }
                                });
                            }
                        })
                }
            },
            closeCreateRoleDialog() {
                this.createRoleDialog = false;
            },
            paginationHandler() {
                let query = {};
                if (this.pagination.page) {
                    query.roles_page = this.pagination.page;
                }
                if (this.pagination.rowsPerPage) {
                    query.roles_per_page = this.pagination.rowsPerPage;
                }
                if (this.pagination.sortBy) {
                    query.roles_order_by = this.pagination.sortBy;
                }
                if (this.pagination.descending !== null) {
                    query.roles_descending = this.pagination.descending;
                }

                this.$router.replace({name: 'admin.users.roles', query: query}, () => {
                    this.retrieveFromApi();
                }, () => {
                    this.retrieveFromApi();
                });
            },
            retrieveFromApi() {
                this.loading = true;

                this.$axios.post('/spa/admin/users/roles', {
                    page: this.$route.query.roles_page,
                    per_page: this.$route.query.roles_per_page,
                    order_by: this.$route.query.roles_order_by,
                    descending: this.$route.query.roles_descending,
                    search: this.search
                })
                    .then((response) => {
                        this.setTable(response.data)
                    });
            },
            setTable(data) {
                this.totalItems = data.paginator.total;
                this.items = data.roles;

                this.loading = false;
            }
        },
        components: {
            'create-role-dialog': CreateRoleDialog
        }
    }
</script>
