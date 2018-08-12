<script>
    import {Line} from 'vue-chartjs'

    export default {
        extends: Line,
        mounted() {
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
                legend: {
                    // Prevent hiding legend on click.
                    onClick() {}
                }
            });
        },
        props: {
            sets: {
                type: Array,
                required: true
            }
        },
        data() {
            return {
                chart: {
                    labels: [
                        1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17,
                        18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31
                    ],
                    datasets: this.sets
                },
                color: '#689F38'
            };
        },
        watch: {
            sets(val) {
                val.forEach(item => {
                    item.backgroundColor = this.color;
                });

                this.chart.datasets = this.sets;
                // Update chart to prepare it to new data set.
                this.$data._chart.update();
            }
        }
    }
</script>