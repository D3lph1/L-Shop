<template>
    <v-container
            id="full"
            fluid
            align-center
            justify-center
    >
        <v-card
                id="enter-card"
                width="300px"
        >
            <v-card
                    id="form-header"
                    color="primary"
            >
                <v-icon medium color="white">hourglass_empty</v-icon>
                <h1 class="text-xs-center">{{ $t('content.frontend.auth.activation.sent.short_title') }}</h1>
            </v-card>

            <v-card-text>
                <p class="body-1" v-html="$t('content.frontend.auth.activation.sent.description')"></p>
            </v-card-text>

            <v-form id="form">
                <v-text-field
                        v-model="email"
                        :label="$t('validation.attributes.email')"
                        required
                        prepend-icon="mail_outline"
                ></v-text-field>
                <v-btn
                        @click="perform"
                        :loading="loadingBtn"
                        :disabled="disabledBtn"
                        block
                        color="primary"
                >
                    {{ $t('content.frontend.auth.password.forgot.continue') }}</v-btn>
            </v-form>

            <v-footer
                    height="auto"
                    id="form-footer"
            >
                <v-tooltip bottom v-if="accessModeAny || accessModeAuth">
                    <v-btn
                            large
                            outline
                            icon
                            color="green"
                            slot="activator"
                            :to="{name: 'frontend.auth.login'}"
                    >
                        <v-icon>vpn_key</v-icon>
                    </v-btn>
                    <span>{{ $t('content.frontend.auth.login.title') }}</span>
                </v-tooltip>

                <v-tooltip bottom v-if="accessModeAny">
                    <v-btn
                            large
                            outline
                            icon
                            color="orange"
                            slot="activator"
                            :to="{name: 'frontend.auth.password.forgot'}"
                    >
                        <v-icon>shopping_cart</v-icon>
                    </v-btn>
                    <span>{{ $t('content.frontend.auth.login.purchase_without_auth') }}</span>
                </v-tooltip>
            </v-footer>
        </v-card>
    </v-container>
</template>

<script>
    import loader from './../../../core/http/loader'

    export default {
        data() {
            return {
                email: '',
                loadingBtn: false,

                accessModeAny: false,
                accessModeAuth: false,
                captcha: ''
            }
        },
        beforeRouteEnter (to, from, next) {
            loader.beforeRouteEnter('/spa/activation/sent', to, from, next);
        },
        beforeRouteUpdate (to, from, next) {
            loader.beforeRouteUpdate('/spa/activation/sent', to, from, next, this);
        },
        computed: {
            disabledBtn() {
                return !this.check();
            }
        },
        methods: {
            check() {
                return this.email.match(/.+@.+\..+/i);
            },
            send() {
                this.loadingBtn = true;
                this.$axios.post('/spa/activation/repeat', {
                    email: this.email
                })
                    .then((response) => {
                        let data = response.data;
                        let status = data.status;
                        if (status === 'success') {
                            //
                        }
                        this.loadingBtn = false;
                    })
                    .catch((err) => {
                        this.loadingBtn = false;
                    });
            },
            perform() {
                if (!this.check()) {
                    return;
                }
                this.send();
            },
            setData(response) {
                const data = response.data;

                this.accessModeAny = data.accessModeAny;
                this.accessModeAuth = data.accessModeAuth;
                this.captcha = data.captcha;
            }
        }
    }
</script>
