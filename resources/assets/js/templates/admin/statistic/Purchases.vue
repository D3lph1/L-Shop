<template>
    <v-card>
        <v-card-title>
            {{ $t('content.admin.statistic.purchases.title') }}
        </v-card-title>
        <v-data-table
                :headers="headers"
                :items="items"
                :pagination.sync="pagination"
                :total-items="totalItems"
                :loading="loading"
                :no-data-text="$t('content.frontend.profile.purchases.table.empty')"
                :rows-per-page-items="[25, 50, 100]"
                :rows-per-page-text="$t('common.table.rows_per_page')"
                class="elevation-1"
        >
            <template slot="pageText" slot-scope="{ pageStart, pageStop }">
                {{ pageStart }} - {{ pageStop }} {{ $t('common.table.of') }} {{ totalItems }}
            </template>

            <template slot="items" slot-scope="props">
                <td class="text-xs-center">{{ props.item.id }}</td>
                <td class="text-xs-center">{{ props.item.user.username !== null ? props.item.user.username : '-' }}</td>
                <td class="text-xs-center">{{ props.item.player !== null ? props.item.player : '-' }}</td>
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
                    <v-btn icon class="mx-0" v-if="props.item.items.length !== 0" @click="openDetailsDialog(props.item)">
                        <v-icon color="secondary">more_horiz</v-icon>
                    </v-btn>
                    <v-btn icon class="mx-0" v-if="props.item.completedAt === null && canComplete" @click="complete(props.item)">
                        <v-icon color="success">check</v-icon>
                    </v-btn>
                </td>
            </template>
        </v-data-table>
        <purchase-details-dialog
                :dialog="detailsDialog"
                :items="details"
                @close="closeDetailsDialog"
        ></purchase-details-dialog>
    </v-card>
</template>

<script>
    import PurchaseDetailsDialog from './../../frontend/profile/PurchaseDetailsDialog.vue'
    import DateTime from './../../../core/common/datetime'

    export default {
        data() {
            return {
                canComplete: false,
                detailsDialog: false,
                details: [],
                totalItems: 0,
                items: [],
                loading: false,
                pagination: {
                    page: this.$route.query.page ? this.$route.query.page : 1,
                    rowsPerPage: this.$route.query.per_page ? parseInt(this.$route.query.per_page) : 25,
                    sortBy: this.$route.query.order_by ? this.$route.query.order_by : 'purchase.id',
                    descending: this.$route.query.descending === 'true',
                },
                headers: [
                    {
                        text: $t('content.frontend.profile.purchases.table.headers.id'),
                        align: 'center',
                        sortable: true,
                        value: 'purchase.id'
                    },
                    {
                        text: $t('common.user'),
                        align: 'center',
                        sortable: false,
                        value: 'user'
                    },
                    {
                        text: $t('common.player'),
                        align: 'center',
                        sortable: true,
                        value: 'purchase.player'
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
                        sortable: true,
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
                        sortable: true,
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

                    this.$router.replace({name: 'admin.statistic.purchases', query: query}, () => {
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

                this.$axios.post('/spa/admin/statistic/purchases', {
                    page: this.$route.query.page,
                    rowsPerPage: this.$route.query.per_page ? parseInt(this.$route.query.per_page) : 25,
                    order_by: this.$route.query.order_by,
                    descending: this.$route.query.descending
                })
                    .then(response => {
                        this.setTable(response.data)
                    });
            },
            setTable(data) {
                this.totalItems = data.paginator.total;
                this.items = data.items;
                this.items.forEach((item) => {
                    item.createdAt = DateTime.localize(new Date(item.createdAt));
                    item.completedAt = item.completedAt !== null ? DateTime.localize(new Date(item.completedAt)) : null;
                });
                this.canComplete = data.canComplete;

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
