<script>
    import {Doughnut} from 'vue-chartjs'
    import Colors from './../../../../core/common/colors'

    export default {
        extends: Doughnut,
        mounted() {
            this.renderChart(this.chart, {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    display: false
                }
            });
        },
        props: {
            dataset: {
                type: Array,
                required: true
            },
            labels: {
                type: Array,
                required: true
            },
            startColor: {
                type: String,
                default: '#64B5F6'
            },
            colorDecrementStep: {
                type: Number,
                default: 50
            }
        },
        data() {
            return {
                chart: {
                    labels: this.labels,
                    datasets: [{
                        data: this.dataset
                    }]
                },
                color: this.startColor
            };
        },
        watch: {
            labels(val) {
                this.chart.labels = val;

                // Update chart to prepare it to new data set.
                this.$data._chart.update();
            },
            dataset(val) {
                let colors = [
                    '#ff6384',
                    '#36a2eb',
                    '#ffcd56'
                ];
                // If the products in the top will be more than items in colors array.
                const first = colors.length;
                for (let i = first; i < val.length; i++) {
                    if (i !== first) {
                        this.color = Colors.decrementHexColor(this.color, this.colorDecrementStep);
                    }
                    colors.push(this.color);
                }

                this.chart.datasets = [{
                    data: val,
                    backgroundColor: colors
                }];

                // Update chart to prepare it to new data set.
                this.$data._chart.update();
            }
        }
    }
</script>
