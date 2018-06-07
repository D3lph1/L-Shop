<template>
    <v-layout row justify-center>
        <v-dialog v-model="dialogData" max-width="700px">
            <v-card>
                <v-card-title>
                    <span class="headline">{{ $t('content.admin.users.edit.actions.cart.title') }}</span>
                </v-card-title>
                <v-card-text>
                    <v-data-table
                            :headers="headers"
                            :items="items"
                            :pagination.sync="pagination"
                            :total-items="totalItems"
                            :loading="loading"
                            :no-data-text="$t('content.frontend.profile.cart.table.empty')"
                            :rows-per-page-items="[25, 50, 100]"
                            :rows-per-page-text="$t('common.table.rows_per_page')"
                            class="elevation-0"
                    >
                        <template slot="pageText" slot-scope="{ pageStart, pageStop }">
                            {{ pageStart }} - {{ pageStop }} {{ $t('common.table.of') }} {{ totalItems }}
                        </template>

                        <template slot="items" slot-scope="props">
                            <td class="text-xs-center"><img :src="props.item.item.image" height="30"></td>
                            <td class="text-xs-center">{{ props.item.item.name }}</td>
                            <td class="text-xs-center">{{ props.item.amount }}</td>
                            <td class="text-xs-center">{{ props.item.product.server }}</td>
                            <td class="text-xs-center">
                                <v-btn icon class="mx-0" :disabled="distributionDisabled" v-if="props.item.attempting" @click="distribute(props.item)">
                                    <v-icon color="secondary">play_for_work</v-icon>
                                </v-btn>
                            </td>
                        </template>
                    </v-data-table>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" flat @click.native="dialogData = false">{{ $t('common.close') }}</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-layout>
</template>

<script>
    export default {
        props: {
            dialog: {
                required: true,
                type: Boolean
            },
            userId: {
                required: true,
                type: Number
            }
        },
        data() {
            return {
                dialogData: this.dialog,
                items: [],
                servers: [],
                distributionDisabled: false,
                totalItems: 0,
                loading: false,
                pagination: {
                    page: 1,
                    sortBy: 'distribution.id',
                    descending: false
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
            dialog(val) {
                this.dialogData = val;
            },
            dialogData(val) {
                if (!val) {
                    this.$emit('close', this.models);
                }
            },
            pagination: {
                handler () {
                    this.retrieveFromApi();
                },
                deep: true
            }
        },
        methods: {
            retrieveFromApi() {
                this.loading = true;

                this.$axios.get(`/spa/admin/users/edit/${this.userId}/cart`, {
                    params: {
                        page: this.pagination.page,
                        per_page: this.pagination.rowsPerPage,
                        order_by: this.pagination.sortBy,
                        descending: this.pagination.descending
                    }
                })
                    .then(response => {
                        this.setTable(response.data)
                    });
            },
            setTable(data) {
                this.totalItems = data.paginator.total;
                this.items = data.distributions;

                this.loading = false;
            },
            distribute(distribution) {
                this.distributionDisabled = true;
                this.$axios.post(`/spa/profile/cart/distribute/${distribution.id}`)
                    .then(() => {
                        this.distributionDisabled = false;
                    });
            }
        }
    }
</script>
