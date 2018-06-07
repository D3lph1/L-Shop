<template>
    <v-layout align-center justify-center>
        <v-flex xs12 sm12 md10 lg8>
            <v-card>
                <v-card-title class="text-xs-center">
                    <h3>{{ $t('content.admin.control.security.title') }}</h3>
                    <v-spacer></v-spacer>
                    <span class="caption" v-html="$t('common.unclear_docs', {link: 'https://github.com/D3lph1/L-shop/wiki'})"></span>
                </v-card-title>
                <v-card-text>
                    <v-subheader>{{ $t('content.admin.control.security.recaptcha.title') }}</v-subheader>
                    <v-switch
                            color="secondary"
                            class="mt-4"
                            :label="$t('content.admin.control.security.recaptcha.enabled')"
                            v-model="captchaEnabled"
                    ></v-switch>
                    <v-text-field
                            :label="$t('content.admin.control.security.recaptcha.public_key')"
                            v-model="recaptchaPublicKey"
                            :disabled="!captchaEnabled"
                    ></v-text-field>
                    <v-text-field
                            :label="$t('content.admin.control.security.recaptcha.secret_key')"
                            v-model="recaptchaSecretKey"
                            :disabled="!captchaEnabled"
                    ></v-text-field>

                    <v-subheader>{{ $t('content.admin.control.security.user_section') }}</v-subheader>
                    <v-switch
                            color="secondary"
                            class="mt-4"
                            :label="$t('content.admin.control.security.reset_password_enabled')"
                            v-model="resetPasswordEnabled"
                    ></v-switch>
                    <v-switch
                            color="secondary"
                            class="mt-4"
                            :label="$t('content.admin.control.security.change_password_enabled')"
                            v-model="changePasswordEnabled"
                    ></v-switch>
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
                captchaEnabled: false,
                recaptchaPublicKey: '',
                recaptchaSecretKey: '',
                resetPasswordEnabled: false,
                changePasswordEnabled: false,

                finishDisabled: false,
                finishLoading: false
            }
        },
        beforeRouteEnter (to, from, next) {
            loader.beforeRouteEnter('/spa/admin/control/security', to, from, next);
        },
        beforeRouteUpdate (to, from, next) {
            loader.beforeRouteUpdate('/spa/admin/control/security', to, from, next, this);
        },
        methods: {
            perform() {
                this.finishLoading = true;
                this.$axios.post('/spa/admin/control/security', {
                    captcha_enabled: this.captchaEnabled,
                    recaptcha_public_key: this.recaptchaPublicKey,
                    recaptcha_secret_key: this.recaptchaPublicKey,
                    reset_password_enabled: this.resetPasswordEnabled,
                    change_password_enabled: this.changePasswordEnabled,
                })
                    .then(() => {
                        this.finishLoading = false;
                    })
            },
            setData(response) {
                const data = response.data;

                this.captchaEnabled = data.captchaEnabled;
                this.recaptchaPublicKey = data.recaptchaPublicKey;
                this.recaptchaSecretKey = data.recaptchaSecretKey;
                this.resetPasswordEnabled = data.resetPasswordEnabled;
                this.changePasswordEnabled = data.changePasswordEnabled;
            }
        }
    }
</script>
