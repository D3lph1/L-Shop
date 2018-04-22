<template>
    <v-layout align-center justify-center>
        <v-flex xs12 sm12 md10 lg8>
            <v-card>
                <v-card-title class="text-xs-center">
                    <h3>{{ $t('content.admin.control.optimization.title') }}</h3>
                    <v-spacer></v-spacer>
                    <span class="caption" v-html="$t('common.unclear_docs', {link: 'https://github.com/D3lph1/L-shop/wiki'})"></span>
                </v-card-title>
                <v-card-text>
                    <v-subheader>{{ $t('content.admin.control.optimization.caching_section') }}</v-subheader>
                    <v-text-field
                            :label="$t('content.admin.control.optimization.monitoring_ttl')"
                            v-model="monitoringTtl"
                            type="number"
                            class="no-spinners"
                    ></v-text-field>
                </v-card-text>
                <v-card-actions>
                    <v-btn flat color="orange" :disabled="finishDisabled" :loading="finishLoading" @click="perform">{{ $t('common.save') }}</v-btn>
                </v-card-actions>
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
    import loader from './../../../core/http/loader'

    export default {
        data() {
            return {
                monitoringTtl: 0,

                finishDisabled: false,
                finishLoading: false,
            }
        },
        beforeRouteEnter (to, from, next) {
            loader.beforeRouteEnter('/spa/admin/control/optimization', to, from, next);
        },
        beforeRouteUpdate (to, from, next) {
            loader.beforeRouteUpdate('/spa/admin/control/optimization', to, from, next, this);
        },
        methods: {
            perform() {
                this.finishLoading = true;
                this.$axios.post('/spa/admin/control/optimization', {
                    monitoring_ttl: this.monitoringTtl
                })
                    .then(response => {
                        this.finishLoading = false;
                    })
            },
            setData(response) {
                const data = response.data;

                this.monitoringTtl = data.monitoringTtl;
            }
        }
    }
</script>
