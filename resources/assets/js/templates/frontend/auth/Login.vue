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
                <v-icon medium color="white">vpn_key</v-icon>
                <h1>{{ $t('content.frontend.auth.login.title') }}</h1>
            </v-card>

            <v-form id="form">
                <v-text-field
                        v-model="username"
                        :label="$t('validation.attributes.username')"
                        prepend-icon="person_outline"
                ></v-text-field>
                <v-text-field
                        v-model="password"
                        :label="$t('validation.attributes.password')"
                        :append-icon-cb="() => (visible = !visible)"
                        :append-icon="visible ? 'visibility' : 'visibility_off'"
                        :type="visible ? 'text' : 'password'"
                        prepend-icon="lock_open"
                ></v-text-field>
                <v-btn
                        @click="perform"
                        :loading="loadingBtn"
                        :disabled="disabledBtn"
                        block
                        color="primary"
                >
                    {{ $t('content.frontend.auth.login.login') }}
                </v-btn>
            </v-form>

            <v-footer
                    height="auto"
                    id="form-footer"
            >
                <v-tooltip bottom v-if="enabledPasswordReset">
                    <v-btn
                            large
                            outline
                            icon
                            color="red"
                            slot="activator"
                            :to="{name: 'frontend.auth.password.forgot'}"
                    >
                        <v-icon>lock_outline</v-icon>
                    </v-btn>
                    <span>{{ $t('content.frontend.auth.login.forgot_password') }}</span>
                </v-tooltip>

                <v-tooltip bottom v-if="enabledRegister && !onlyForAdmins">
                    <v-btn
                            large
                            outline
                            icon
                            color="green"
                            slot="activator"
                            :to="{name: 'frontend.auth.register'}"
                    >
                        <v-icon>person_add</v-icon>
                    </v-btn>
                    <span>{{ $t('content.frontend.auth.register.title') }}</span>
                </v-tooltip>

                <v-tooltip bottom v-if="accessModeAny">
                    <v-btn
                            large
                            outline
                            icon
                            color="orange"
                            slot="activator"
                            :to="{name: 'frontend.auth.servers'}"
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
                username: '',
                password: '',
                visible: false,
                loadingBtn: false,

                onlyForAdmins: false,
                accessModeAny: false,
                downForMaintenance: false,
                enabledPasswordReset: false,
                enabledRegister: false
            }
        },
        beforeRouteEnter (to, from, next) {
            loader.beforeRouteEnter('/spa/login', to, from, next);
        },
        beforeRouteUpdate (to, from, next) {
            loader.beforeRouteUpdate('/spa/login', to, from, next, this);
        },
        computed: {
            disabledBtn() {
                return !this.check();
            }
        },
        methods: {
            check() {
                this.username = this.username.trim();
                return this.username.length !== 0 && this.password.length !== 0;
            },
            send() {
                this.loadingBtn = true;
                this.$axios.post('/spa/login', {
                    username: this.username,
                    password: this.password
                })
                    .then((response) => {
                        let data = response.data;
                        let status = data.status;
                        if (status === 'success') {
                            this.$router.replace({name: 'frontend.auth.servers'});

                            return;
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

                this.enabledRegister = data.enabledRegister;
                this.onlyForAdmins = data.onlyForAdmins;
                this.enabledPasswordReset = data.enabledPasswordReset;
                this.accessModeAny = data.accessModeAny;
                this.downForMaintenance = data.downForMaintenance;
                this.enabledPasswordReset = data.enabledPasswordReset;
                this.enabledRegister = data.enabledRegister;
            }
        }
    }
</script>
