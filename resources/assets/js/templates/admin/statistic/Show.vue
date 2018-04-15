<template>
    <v-layout row wrap>
        <v-flex xs12 md6 class="text-xs-center">
            <p class="headline">{{ $t('content.admin.statistic.show.profit_for_year') }}</p>
            <chart-for-year
                    :sets="profitForYear"
                    color="#64B5F6"
                    decrement-color-step="50"
                    @point-click="profitMonthChanged"
            ></chart-for-year>
        </v-flex>
        <v-flex xs12 md6 class="text-xs-center">
            <p class="headline">{{ $t('content.admin.statistic.show.profit_for_month') }}</p>
            <chart-for-month
                    :sets="profitForMonth"
            ></chart-for-month>
        </v-flex>

        <v-flex xs12 md6 class="text-xs-center mt-4">
            <p class="headline">{{ $t('content.admin.statistic.show.purchases_for_year') }}</p>
            <chart-for-year
                    :sets="purchasesForYear"
                    color="#64B5F6"
                    @point-click="purchasesMonthChanged"
            ></chart-for-year>
        </v-flex>
        <v-flex xs12 md6 class="text-xs-center mt-4">
            <p class="headline">{{ $t('content.admin.statistic.show.purchases_for_month') }}</p>
            <chart-for-month
                    :sets="purchasesForMonth"
            ></chart-for-month>
        </v-flex>

        <v-flex xs12 md6 class="text-xs-center mt-4">
            <p class="headline">{{ $t('content.admin.statistic.show.registered_for_year') }}</p>
            <chart-for-year
                    :sets="registeredForYear"
                    color="#64B5F6"
                    @point-click="registeredMonthChanged"
            ></chart-for-year>
        </v-flex>
        <v-flex xs12 md6 class="text-xs-center mt-4">
            <p class="headline">{{ $t('content.admin.statistic.show.registered_for_month') }}</p>
            <chart-for-month
                    :sets="registeredForMonth"
            ></chart-for-month>
        </v-flex>
        <v-flex xs12 class="text-xs-center mt-5">
            <p class="headline">{{ $t('content.admin.statistic.show.top_purchased_products') }}</p>
            <chart-top-products
                    :labels="topPurchasedProductsLabels"
                    :dataset="topPurchasedProductsDataset"
            ></chart-top-products>
        </v-flex>
        <v-flex cs12 class="text-xs-center mt-5">
            <p class="headline">{{ $t('content.admin.statistic.show.table.title') }}</p>
            <v-data-table
                    :headers="tableHeaders"
                    :items="tableItems"
                    hide-actions
            >
                <template slot="items" slot-scope="props">
                    <td class="text-xs-left">{{ props.item.name }}</td>
                    <td class="text-xs-left" v-html="props.item.value"></td>
                </template>
            </v-data-table>
        </v-flex>
    </v-layout>
</template>

<script>
    import loader from './../../../core/http/loader'
    import ChartForYear from './charts/ChartForYear.vue'
    import ChartForMonth from './charts/ChartForMonth.vue'
    import ChartTopProducts from './charts/ChartTopProducts.vue'

    export default {
        data() {
            return {
                profitForYear: [],
                profitForMonth: [],
                purchasesForYear: [],
                purchasesForMonth: [],
                registeredForYear: [],
                registeredForMonth: [],
                topPurchasedProductsLabels: [],
                topPurchasedProductsDataset: [],
                tableHeaders: [
                    {text: $t('content.admin.statistic.show.table.headers.name'), value: 'name', sortable: false, align: 'left'},
                    {text: $t('content.admin.statistic.show.table.headers.value'), value: 'value', sortable: false, align: 'left'},
                ],
                tableItems: [
                    {
                        name: $t('content.admin.statistic.show.table.items.profit'),
                        value: 0
                    },
                    {
                        name: $t('content.admin.statistic.show.table.items.amount_purchases'),
                        value: 0
                    },
                    {
                        name: $t('content.admin.statistic.show.table.items.amount_fill_balance'),
                            value: 0
                    },
                    {
                        name: $t('content.admin.statistic.show.table.items.users_registered'),
                        value: 0
                    }
                ]
            }
        },
        beforeRouteEnter (to, from, next) {
            loader.beforeRouteEnter('/api/admin/statistic/show', to, from, next);
        },
        beforeRouteUpdate (to, from, next) {
            loader.beforeRouteUpdate('/api/admin/statistic/show', to, from, next, this);
        },
        methods: {
            setData(response) {
                const data = response.data;
                // Init profit for year chart.
                this.setChartForYear(data.profitForYear, this.profitForYear, 'total');
                // Init profit for month chart.
                this.setChartForMonth(data.year, data.month, data.profitForMonth, this.profitForMonth, 'total');
                // Init purchases count for year chart.
                this.setChartForYear(data.purchasesForYear, this.purchasesForYear, 'amount');
                // Init purchases count for month chart.
                this.setChartForMonth(data.year, data.month, data.purchasesForMonth, this.purchasesForMonth, 'amount');
                // Init registered users count for year chart.
                this.setChartForYear(data.registeredForYear, this.registeredForYear, 'amount');
                // Init registered users count for month chart.
                this.setChartForMonth(data.year, data.month, data.registeredForMonth, this.registeredForMonth, 'amount');

                this.setTopPurchasedProducts(data.topPurchasedProducts);

                this.tableItems[0].value = `${data.totalProfit} ${this.$store.state.shop.currency.html}`;
                this.tableItems[1].value = data.totalPurchasesAmount;
                this.tableItems[2].value = data.fillBalanceAmount;
                this.tableItems[3].value = data.registeredUserAmount;
            },
            fillArray(src, index, value, maxIndex) {
                for (let i = 1; i <= maxIndex; i++) {
                    if (typeof src[i] === 'undefined') {
                        src[i] = 0;
                    }
                }

                // Decrement the index since the indexing of the months in the chart starts from zero.
                src[--index] = value;

                return src;
            },
            setChartForYear(src, target, valueKey) {
                src.forEach(item => {
                    let found = null;
                    target.forEach(each => {
                        if (item.year === each.label) {
                            found = each;
                        }
                    });
                    if (found === null) {
                        target.push({
                            label: item.year,
                            data: this.fillArray([], item.month, item[valueKey], 12)
                        });
                    } else {
                        found.data = this.fillArray(found.data, item.month, item[valueKey], 12);
                    }
                });
            },
            profitMonthChanged(targets) {
                const datasetIndex = 0;
                const dataset = this.profitForYear[targets[datasetIndex]._datasetIndex];
                // Increment the index since the indexing of the months in the chart starts from zero.
                this.loadForMonth(
                    '/api/admin/statistic/show/profit/month',
                    dataset.label,
                    targets[datasetIndex]._index + 1,
                    'profitForMonth',
                    this.profitForMonth,
                    'total'
                )
            },
            purchasesMonthChanged(targets) {
                const datasetIndex = 0;
                const dataset = this.purchasesForYear[targets[datasetIndex]._datasetIndex];
                // Increment the index since the indexing of the months in the chart starts from zero.
                this.loadForMonth(
                    '/api/admin/statistic/show/purchases/month',
                    dataset.label,
                    targets[datasetIndex]._index + 1,
                    'purchasesForMonth',
                    this.purchasesForMonth,
                    'amount'
                )
            },
            registeredMonthChanged(targets) {
                const datasetIndex = 0;
                const dataset = this.registeredForYear[targets[datasetIndex]._datasetIndex];
                // Increment the index since the indexing of the months in the chart starts from zero.
                this.loadForMonth(
                    '/api/admin/statistic/show/registered/month',
                    dataset.label,
                    targets[datasetIndex]._index + 1,
                    'registeredForMonth',
                    this.registeredForMonth,
                    'amount'
                )
            },
            loadForMonth(url, year, month, src, target, valueKey) {
                this.$axios.post(url, {
                    year,
                    month
                })
                    .then(response => {
                        if (response.data.status === 'success') {
                            this.setChartForMonth(year, month, response.data[src], target, valueKey)
                        }
                    });
            },
            setChartForMonth(year, month, src, target, valueKey) {
                let data = [];
                data = this.fillArray(data, 0, 0, 31);
                src.forEach(item => {
                    data = this.fillArray(data, item.day, item[valueKey], 31);
                });
                target.pop();
                target.push({
                    label: `${$t(`datetime.months.${month}`)} ${year}`,
                    data : data
                });
            },
            setTopPurchasedProducts(products) {
                let labels = [];
                let dataset = [];
                products.forEach(item => {
                    labels.push(`${item.name}, ${item.price} ${this.$store.state.shop.currency.plain} (${item.server}/${item.category})`);
                    dataset.push(item.amount);
                });

                this.topPurchasedProductsLabels = labels;
                this.topPurchasedProductsDataset = dataset;
            }
        },
        components: {
            'chart-for-year': ChartForYear,
            'chart-for-month': ChartForMonth,
            'chart-top-products': ChartTopProducts
        }
    }
</script>
