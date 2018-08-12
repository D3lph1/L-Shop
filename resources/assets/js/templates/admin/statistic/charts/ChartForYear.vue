<script>
    import {Line} from 'vue-chartjs'
    import Colors from './../../../../core/common/colors'

    export default {
        extends: Line,
        mounted() {
            const self = this;
            this.renderChart(this.chart, {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                onClick(event) {
                    const targets = self.$data._chart.getElementsAtEvent(event);
                    if (targets.length !== 0) {
                        self.$emit('point-click', targets);
                    }
                }
            });
        },
        props: {
            sets: {
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
                    labels: [
                        $t('datetime.months.1'),
                        $t('datetime.months.2'),
                        $t('datetime.months.3'),
                        $t('datetime.months.4'),
                        $t('datetime.months.5'),
                        $t('datetime.months.6'),
                        $t('datetime.months.7'),
                        $t('datetime.months.8'),
                        $t('datetime.months.9'),
                        $t('datetime.months.10'),
                        $t('datetime.months.11'),
                        $t('datetime.months.12')
                    ],
                    datasets: this.sets
                },
                color: this.startColor
            };
        },
        watch: {
            sets(val) {
                let first = true;
                val.forEach(item => {
                    if (!first) {
                        this.color = Colors.decrementHexColor(this.color, this.colorDecrementStep);
                    }

                    item.backgroundColor = this.color;
                    first = false;
                });

                this.chart.datasets = this.sets;
                // Update chart to prepare it to new data set.
                this.$data._chart.update();
            }
        }
    }
</script>
