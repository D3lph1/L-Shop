<template>
    <v-dialog persistent v-model="dialog" max-width="400">
        <v-card>
            <v-card-title class="headline">{{ $t('content.frontend.shop.cart.purchase_dialog.title') }}</v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <p class="mb-0">
                    <v-text-field
                            v-if="!$store.getters.isAuth"
                            v-model="username"
                            class="pt-0"
                            :prefix="$t('common.username') + ':'"
                            :hint="$t('content.frontend.shop.catalog.purchase.username_description')"
                            prepend-icon="person"
                    ></v-text-field>
                </p>
                <p class="mb-0 text-xs-center">
                    <vue-recaptcha
                            class="recaptcha-in-dialog"
                            v-if="captchaKey"
                            :sitekey="captchaKey"
                            @verify="setReCaptchaResponse"
                    >
                    </vue-recaptcha>
                </p>
            </v-card-text>

            <v-divider></v-divider>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                        flat
                        round
                        color="orange"
                        @click="$emit('hide')"
                >
                    {{ $t('common.cancel') }}
                </v-btn>
                <v-btn
                        flat
                        round
                        color="green"
                        :loading="loadingPurchaseBtn"
                        @click="purchase"
                >
                    {{ $t('content.frontend.shop.catalog.purchase.purchase') }}
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    import VueRecaptcha from 'vue-recaptcha';

    export default {
        props: {
            dialog: false,
            items: {
                required: true,
                type: Array
            },
            captchaKey: {
                required: false
            }
        },
        data() {
            return {
                username: '',
                loadingPurchaseBtn: false,
                reCaptchaResponse: null
            }
        },
        methods: {
            setReCaptchaResponse(response) {
                this.reCaptchaResponse = response;
            },
            resetCaptcha() {
                if (this.captchaKey) {
                    grecaptcha.reset();
                }
            },
            purchase() {
                this.loadingPurchaseBtn = true;
                this.$axios.post(`/spa/cart/${this.$route.params.server}`, {
                    items: this.items,
                    username: this.username,
                    _captcha: this.reCaptchaResponse
                })
                    .then(response => {
                        const data = response.data;
                        this.resetCaptcha();
                        if (data.status === 'success') {
                            if (data.quick) {
                                this.$store.commit('setBalance', data.newBalance);
                            } else {
                                this.$router.push({name: 'frontend.shop.payment', params: {purchase: data.purchaseId}});
                            }
                            this.$emit('success', data.quick);
                            this.$emit('hide');
                        }
                        this.loadingPurchaseBtn = false;
                    })
                    .catch(err => {
                        this.loadingPurchaseBtn = false;
                        this.resetCaptcha()
                    });
            }
        },
        components: {
            'vue-recaptcha': VueRecaptcha
        }
    }
</script>
