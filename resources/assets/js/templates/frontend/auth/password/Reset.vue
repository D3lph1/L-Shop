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
                <v-icon medium color="white">repeat</v-icon>
                <h1 class="text-xs-center">{{ $t('content.frontend.auth.password.forgot.title') }}</h1>
            </v-card>

            <v-form id="form">
                <v-text-field
                        v-model="password"
                        :label="$t('validation.attributes.password')"
                        :append-icon-cb="() => (visible = !visible)"
                        :append-icon="visible ? 'visibility' : 'visibility_off'"
                        :type="visible ? 'text' : 'password'"
                        prepend-icon="lock_outline"
                ></v-text-field>
                <v-text-field
                        v-model="passwordConfirmation"
                        :label="$t('validation.attributes.password_confirmation')"
                        :append-icon-cb="() => (visibleConfirm = !visibleConfirm)"
                        :append-icon="visibleConfirm ? 'visibility' : 'visibility_off'"
                        :type="visibleConfirm ? 'text' : 'password'"
                        prepend-icon="lock_outline"
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
    import loader from './../../../../core/http/loader'

    export default {
        data() {
            return {
                password: '',
                passwordConfirmation: '',
                loadingBtn: false,
                visible: false,
                visibleConfirm: false,

                accessModeAny: false,
                accessModeAuth: false
            }
        },
        beforeRouteEnter (to, from, next) {
            loader.beforeRouteEnter(`/spa/password/reset/${to.params.code}`, to, from, next);
        },
        beforeRouteUpdate (to, from, next) {
            loader.beforeRouteUpdate(`/spa/password/reset/${to.params.code}`, to, from, next, this);
        },
        computed: {
            disabledBtn() {
                return !this.check();
            },
            code() {
                return this.$route.params.code;
            }
        },
        methods: {
            check() {
                return this.password !== '' &&
                    this.passwordConfirmation !== '';
            },
            send() {
                this.loadingBtn = true;
                this.$axios.post(`/spa/password/reset/${this.$route.params.code}`, {
                    password: this.password,
                    password_confirmation: this.passwordConfirmation
                })
                    .then((response) => {
                        let data = response.data;
                        let status = data.status;
                        if (status === 'success') {
                            this.$router.push({name: 'frontend.auth.login'})
                        } else {
                            this.loadingBtn = false;
                        }
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
                if (data.status === 'success') {
                    this.accessModeAny = data.accessModeAny;
                    this.accessModeAuth = data.accessModeAuth;

                    return;
                }

                this.$router.push({name: 'frontend.auth.login'});
            }
        }
    }
</script>
