<template>
    <v-layout row justify-center>
        <v-dialog v-model="dialogData" max-width="700px">
            <v-card>
                <v-card-title>
                    <span class="headline">{{ $t('content.admin.users.edit.actions.purchase_history.title') }}</span>
                </v-card-title>
                <v-card-text>
                    <v-data-table
                            :headers="headers"
                            :items="items"
                            :pagination.sync="pagination"
                            :total-items="totalItems"
                            :loading="loading"
                            :no-data-text="$t('content.frontend.profile.purchases.table.empty')"
                            :rows-per-page-items="[25, 50, 100]"
                            :rows-per-page-text="$t('common.table.rows_per_page')"
                            class="elevation-0"
                    >
                        <template slot="pageText" slot-scope="{ pageStart, pageStop }">
                            {{ pageStart }} - {{ pageStop }} {{ $t('common.table.of') }} {{ totalItems }}
                        </template>

                        <template slot="items" slot-scope="props">
                            <td class="text-xs-center">{{ props.item.id }}</td>
                            <td class="text-xs-center">{{ props.item.cost }} <span v-html="$store.state.shop.currency.html"></span></td>
                            <td class="text-xs-center">
                                {{ props.item.items.length === 0 ? $t('content.frontend.profile.purchases.table.type.refill') : $t('content.frontend.profile.purchases.table.type.products') }}
                            </td>
                            <td class="text-xs-center">{{ props.item.createdAt }}</td>
                            <td class="text-xs-center">{{ props.item.completedAt !== null ? props.item.completedAt : '-' }}</td>
                            <td class="text-xs-center">
                                <span v-if="props.item.via.quick">-</span>
                                <span v-else-if="props.item.via.byAdmin">{{ $t('content.frontend.profile.purchases.via.by_admin') }}</span>
                                <span v-else>{{ props.item.via.value }}</span>
                            </td>
                            <td class="text-xs-left layout px-0">
                                <v-tooltip bottom v-if="props.item.items.length !== 0">
                                    <v-btn class="product-btn mx-0"
                                           color="secondary"
                                           icon
                                           flat
                                           slot="activator"
                                           @click="openDetailsDialog(props.item)"
                                    >
                                        <v-icon>more_horiz</v-icon>
                                    </v-btn>
                                    <span>{{ $t('content.frontend.profile.purchases.table.details') }}</span>
                                </v-tooltip>
                                <v-tooltip bottom v-if="props.item.completedAt === null">
                                    <v-btn class="product-btn mx-0"
                                           color="success"
                                           icon
                                           flat
                                           slot="activator"
                                           :to="{name: 'frontend.shop.payment', params: {purchase: props.item.id}}"
                                    >
                                        <v-icon>navigate_next</v-icon>
                                    </v-btn>
                                    <span>{{ $t('content.frontend.profile.purchases.table.pay') }}</span>
                                </v-tooltip>
                                <v-tooltip bottom v-if="props.item.completedAt === null && canComplete">
                                    <v-btn class="product-btn mx-0"
                                           color="success"
                                           icon
                                           flat
                                           slot="activator"
                                           @click="complete(props.item)"
                                    >
                                        <v-icon>check</v-icon>
                                    </v-btn>
                                    <span>{{ $t('content.frontend.profile.purchases.table.complete') }}</span>
                                </v-tooltip>
                            </td>
                        </template>
                    </v-data-table>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" flat @click.native="dialogData = false">{{ $t('common.close') }}</v-btn>
                </v-card-actions>
                <purchase-details-dialog
                        :dialog="detailsDialog"
                        :items="details"
                        @close="closeDetailsDialog"
                ></purchase-details-dialog>
            </v-card>
        </v-dialog>
    </v-layout>
</template>

<script>
    import PurchaseDetailsDialog from './../../frontend/profile/PurchaseDetailsDialog.vue'
    import DateTime from './../../../core/common/datetime'

    export default {
        props: {
            dialog: {
                required: true,
                type: Boolean
            },
            userId: {
                required: true,
                type: Number
            },
            canComplete: {
                required: true,
                type: Boolean
            }
        },
        data() {
            return {
                dialogData: this.dialog,
                detailsDialog: false,
                totalItems: 0,
                items: [],
                loading: false,
                details: [],
                pagination: {
                    page: 1,
                    rowsPerPage: 25,
                    sortBy: 'purchase.id',
                    descending: false,
                },
                headers: [
                    {
                        text: $t('content.frontend.profile.purchases.table.headers.id'),
                        align: 'center',
                        sortable: true,
                        value: 'purchase.id'
                    },
                    {
                        text: $t('content.frontend.profile.purchases.table.headers.cost'),
                        align: 'center',
                        sortable: true,
                        value: 'purchase.cost'
                    },
                    {
                        text: $t('common.type'),
                        align: 'center',
                        sortable: false,
                        value: 'purchase.type'
                    },
                    {
                        text: $t('content.frontend.profile.purchases.table.headers.created_at'),
                        align: 'center',
                        sortable: true,
                        value: 'purchase.createdAt'
                    },
                    {
                        text: $t('content.frontend.profile.purchases.table.headers.completed_at'),
                        align: 'center',
                        sortable: true,
                        value: 'purchase.completedAt'
                    },
                    {
                        text: $t('content.frontend.profile.purchases.table.headers.via'),
                        align: 'center',
                        sortable: false,
                        value: 'purchase.via'
                    },
                    {
                        text: $t('common.actions'),
                        align: 'left',
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

                this.$axios.get(`/spa/admin/users/edit/${this.userId}/purchases`, {
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
                this.items = data.purchases;
                this.items.forEach((item) => {
                    item.createdAt = DateTime.localize(new Date(item.createdAt));
                    item.completedAt = item.completedAt !== null ? DateTime.localize(new Date(item.completedAt)) : null;
                });

                this.loading = false;
            },
            openDetailsDialog(purchase) {
                this.detailsDialog = true;
                this.details = purchase.items.length !== 0 ? purchase.items : [];
            },
            closeDetailsDialog() {
                this.detailsDialog = false;
            },
            complete(purchase) {
                this.$axios.post(`/spa/admin/statistic/purchases/complete/${purchase.id}`)
                    .then(response => {
                        if (response.data.status === 'success') {
                            purchase.completedAt = DateTime.localize(new Date(response.data.completedAt));
                            purchase.via = response.data.via;
                        }
                    });
            }
        },
        components: {
            'purchase-details-dialog': PurchaseDetailsDialog
        }
    }
</script>
