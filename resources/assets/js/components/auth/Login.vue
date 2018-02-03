<template>
    <div class="full-h flex-center pd-v-form">
        <div class="card no-pdh z-depth-4 col-xl-4 col-md-6 col-11">

            <div class="card-block">
                <div class="card-header d_orange text-center white-text z-depth-2">
                    <h1>{{ $t('content.auth.signin.title') }}<i class="fa fa-sign-in fa-lg fa-right"></i></h1>
                </div>
                <div v-if="onlyForAdmins || downForMaintenance" class="alert alert-info text-center">
                    {{ $t('content.auth.signin.only_for_admins') }}
                </div>
                <div class="md-form">
                    <i class="fa fa-user fa-lg prefix"></i>
                    <input type="text" id="si-username" class="form-control" v-model="username" @keyup.enter="perform">
                    <label for="si-username">{{ $t('content.all.username') }}</label>
                </div>
                <div class="md-form">
                    <i class="fa fa-lock fa-lg prefix"></i>
                    <input type="password" id="si-password" class="form-control" v-model="password" @keyup.enter="perform">
                    <label for="si-password">{{ $t('content.all.password') }}</label>
                </div>
                <div class="col-12 text-center">
                    <button class="btn btn-warning btn-lg" @click="perform">{{ $t('content.auth.signin.btn') }}</button>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div v-if="enableRegister && !onlyForAdmins" class="col-12 text-center">
                        <a :href="routeRegister"><i class="fa fa-user-plus fa-left"></i> {{ $t('content.auth.signin.signup') }}</a>
                    </div>
                    <div v-if="enablePasswordReset" class="col-12 text-center">
                        <a :href="routeForgot"><i class="fa fa-unlock fa-left"></i> {{ $t('content.auth.signin.forgot') }}</a>
                    </div>
                    <div v-if="accessModeAny" class="col-12 text-center">
                        <a :href="routeServers"><i class="fa fa-shopping-cart"></i> {{ $t('content.auth.signin.guest') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Url from "../../common/url";

    export default {
        props: [
            'routeLogin', 'routeServers', 'onlyForAdmins', 'downForMaintenance', 'enablePasswordReset', 'routeForgot',
            'enableRegister', 'onlyForAdmins', 'routeRegister', 'accessModeAny', 'routeServers'
        ],
        data() {
            return {
                username: '',
                password: ''
            }
        },
        methods: {
            check() {
                this.username = this.username.trim();

                return this.username.length !== 0 && this.password.length !== 0;
            },
            send() {
                axios.post(this.routeLogin, {
                    username: this.username,
                    password: this.password
                })
                    .then((response) => {
                        let data = response.data;
                        let status = data.status;
                        if (status === 'success') {
                            let to = Url.getParams()['to'];
                            if (to) {
                                Url.redirect(to);
                            } else {
                                Url.redirect(this.routeServers);
                            }
                        }
                    });
            },
            perform() {
                if (!this.check()) {
                    return;
                }

                this.send();
            }
        }
    }
</script>