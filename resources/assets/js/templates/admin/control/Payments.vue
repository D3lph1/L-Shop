<template>
    <v-container fluid grid-list-sm>
        <v-layout row wrap fluid>
            <v-flex xs12 sm12 md6>
                <v-card>
                    <v-card-title class="text-xs-center">
                        <h3>{{ $t('content.admin.control.basic.title') }}</h3>
                        <v-spacer></v-spacer>
                        <span class="caption" v-html="$t('common.unclear_docs', {link: 'https://github.com/D3lph1/L-shop/wiki'})"></span>
                    </v-card-title>
                    <v-card-text>
                        <v-subheader>{{ $t('content.admin.control.payments.basic_section') }}</v-subheader>
                        <v-text-field
                                :label="$t('content.admin.control.payments.min_fill_balance_sum')"
                                v-model="minFillBalanceSum"
                                type="number"
                                class="no-spinners"
                        ></v-text-field>
                        <v-subheader class="mt-4">{{ $t('content.admin.control.payments.aggregators_section') }}</v-subheader>
                        <v-subheader inset>{{ $t('content.admin.control.payments.robokassa.title') }}</v-subheader>
                        <v-switch
                                color="secondary"
                                class="mt-4"
                                :label="$t('content.admin.control.payments.robokassa.enabled')"
                                v-model="robokassaEnabled"
                        ></v-switch>
                        <v-text-field
                                :label="$t('content.admin.control.payments.robokassa.login')"
                                v-model="robokassaLogin"
                                :disabled="!robokassaEnabled"
                        ></v-text-field>
                        <v-text-field
                                :label="$t('content.admin.control.payments.robokassa.payment_password')"
                                v-model="robokassaPaymentPassword"
                                type="password"
                                :disabled="!robokassaEnabled"
                        ></v-text-field>
                        <v-text-field
                                :label="$t('content.admin.control.payments.robokassa.validation_password')"
                                v-model="robokassaValidationPassword"
                                type="password"
                                :disabled="!robokassaEnabled"
                        ></v-text-field>
                        <v-select
                                :items="robokassaAlgorithms"
                                v-model="robokassaAlgorithm"
                                :hint="$t('content.admin.control.payments.robokassa.algorithm')"
                                :disabled="!robokassaEnabled"
                                persistent-hint
                                single-line
                        ></v-select>
                        <v-switch
                                color="secondary"
                                class="mt-4"
                                :label="$t('content.admin.control.payments.robokassa.test')"
                                v-model="robokassaTest"
                                :disabled="!robokassaEnabled"
                        ></v-switch>
                    </v-card-text>
                </v-card>
            </v-flex>
            <v-flex xs12 sm12 md6>
                <v-card>
                    <v-card-text>
                        <v-subheader inset>{{ $t('content.admin.control.payments.interkassa.title') }}</v-subheader>
                        <v-switch
                                color="secondary"
                                class="mt-4"
                                :label="$t('content.admin.control.payments.interkassa.enabled')"
                                v-model="interkassaEnabled"
                        ></v-switch>
                        <v-text-field
                                :label="$t('content.admin.control.payments.interkassa.checkout_id')"
                                v-model="interkassaCheckoutId"
                                :disabled="!interkassaEnabled"
                        ></v-text-field>
                        <v-text-field
                                :label="$t('content.admin.control.payments.interkassa.key')"
                                v-model="interkassaKey"
                                type="password"
                                :disabled="!interkassaEnabled"
                        ></v-text-field>
                        <v-text-field
                                :label="$t('content.admin.control.payments.interkassa.test_key')"
                                v-model="interkassaTestKey"
                                type="password"
                                :disabled="!interkassaEnabled"
                        ></v-text-field>
                        <v-text-field
                                :label="$t('content.admin.control.payments.interkassa.currency')"
                                v-model="interkassaCurrency"
                                :disabled="!interkassaEnabled"
                        ></v-text-field>
                        <v-select
                                :items="interkassaAlgorithms"
                                v-model="interkassaAlgorithm"
                                :hint="$t('content.admin.control.payments.interkassa.algorithm')"
                                :disabled="!interkassaEnabled"
                                persistent-hint
                                single-line
                        ></v-select>
                        <v-switch
                                color="secondary"
                                class="mt-4"
                                :label="$t('content.admin.control.payments.interkassa.test')"
                                v-model="interkassaTest"
                                :disabled="!interkassaEnabled"
                        ></v-switch>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn flat color="orange" :loading="finishLoading" :disabled="finishDisabled" @click="perform">{{ $t('common.save') }}</v-btn>
                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    import loader from './../../../core/http/loader'

    export default {
        data() {
            return {
                minFillBalanceSum: 0,
                robokassaEnabled: false,
                robokassaLogin: '',
                robokassaPaymentPassword: '',
                robokassaValidationPassword: '',
                robokassaAlgorithm: null,
                robokassaAlgorithms: [
                    'md5',
                    'ripemd160',
                    'sha1',
                    'sha256',
                    'sha384',
                    'sha512'
                ],
                robokassaTest: false,

                interkassaEnabled: false,
                interkassaCheckoutId: '',
                interkassaKey: '',
                interkassaTestKey: '',
                interkassaCurrency: '',
                interkassaAlgorithm: null,
                interkassaAlgorithms: [
                    'md5',
                    'sha256'
                ],
                interkassaTest: false,

                finishLoading: false,
                finishDisabled: false
            }
        },
        beforeRouteEnter (to, from, next) {
            loader.beforeRouteEnter('/spa/admin/control/payments', to, from, next);
        },
        beforeRouteUpdate (to, from, next) {
            loader.beforeRouteUpdate('/spa/admin/control/payments', to, from, next, this);
        },
        methods: {
            perform() {
                this.finishLoading = true;
                this.$axios.post('/spa/admin/control/payments', {
                    min_fill_balance_sum: this.minFillBalanceSum,
                    robokassa_enabled: this.robokassaEnabled,
                    robokassa_login: this.robokassaLogin,
                    robokassa_payment_password: this.robokassaPaymentPassword,
                    robokassa_validation_password: this.robokassaValidationPassword,
                    robokassa_algorithm: this.robokassaAlgorithm,
                    robokassa_test: this.robokassaTest,

                    interkassa_enabled: this.interkassaEnabled,
                    interkassa_checkout_id: this.interkassaCheckoutId,
                    interkassa_key: this.interkassaKey,
                    interkassa_test_key: this.interkassaTestKey,
                    interkassa_currency: this.interkassaCurrency,
                    interkassa_algorithm: this.interkassaAlgorithm,
                    interkassa_test: this.interkassaTest,
                })
                    .then(response => {
                        this.finishLoading = false;
                    })
            },
            setData(response) {
                const data = response.data;

                this.minFillBalanceSum = data.minFillBalanceSum;
                this.robokassaEnabled = data.robokassaEnabled;
                this.robokassaLogin = data.robokassaLogin;
                this.robokassaPaymentPassword = data.robokassaPaymentPassword;
                this.robokassaValidationPassword = data.robokassaValidationPassword;
                this.robokassaAlgorithm = data.robokassaAlgorithm;
                this.robokassaTest = data.robokassaTest;

                this.interkassaEnabled = data.interkassaEnabled;
                this.interkassaCheckoutId = data.interkassaCheckoutId;
                this.interkassaKey = data.interkassaKey;
                this.interkassaTestKey = data.interkassaTestKey;
                this.interkassaCurrency = data.interkassaCurrency;
                this.interkassaAlgorithm = data.interkassaAlgorithm;
                this.interkassaTest = data.interkassaTest;
            }
        }
    }
</script>
