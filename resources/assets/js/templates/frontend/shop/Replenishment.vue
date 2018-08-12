<template>
    <div id="replenish-page">
        <v-form id="replenish-form">
            <v-text-field
                    type="number"
                    class="no-spinners"
                    :label="$t('content.frontend.shop.replenishment.sum')"
                    v-model="sum"
                    prepend-icon="money"
            ></v-text-field>
            <div id="captcha" v-if="captchaKey">
                <vue-recaptcha
                        :sitekey="captchaKey"
                        @verify="setReCaptchaResponse"
                >
                </vue-recaptcha>
            </div>
            <v-btn
                    color="primary"
                    block
                    :loading="loading"
                    @click="perform"
            >{{ $t('content.frontend.shop.replenishment.btn') }}</v-btn>
        </v-form>
    </div>
</template>

<script>
    import loader from './../../../core/http/loader'
    import VueRecaptcha from 'vue-recaptcha';

    export default {
        data() {
            return {
                sum: 0,
                loading: false,
                captchaKey: null,
                captchaResponse: null
            }
        },
        beforeRouteEnter(to, from, next) {
            loader.beforeRouteEnter('/spa/replenishment', to, from, next);
        },
        beforeRouteUpdate(to, from, next) {
            loader.beforeRouteUpdate('/spa/replenishment', to, from, next, this);
        },
        methods: {
            perform() {
                this.loading = true;
                this.$axios.post('/spa/replenishment', {
                    sum: this.sum,
                    _captcha: this.captchaResponse
                })
                    .then(response => {
                        const data = response.data;

                        if (data.status === 'success') {
                            this.$router.push({name: 'frontend.shop.payment', params: {purchase: data.purchaseId}});
                        } else {
                            this.loading = false;
                        }
                    })
                    .catch(err => {
                        this.loading = false;
                    });
            },
            setReCaptchaResponse(response) {
                this.captchaResponse = response;
            },
            setData(response) {
                const data = response.data;

                this.captchaKey = data.captchaKey;
            }
        },
        components: {
            'vue-recaptcha': VueRecaptcha
        }
    }
</script>

<style lang="less" scoped>
    #replenish-page {
        display: flex;
        justify-content: center;
        #replenish-form {
            width: 300px;
        }
        #captcha {
            width: 300px;
            height: 74px;
            margin-bottom: 15px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    }
</style>
