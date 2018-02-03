<template>
    <div class="full-h flex-center pd-v-form">
        <div class="card no-pdh z-depth-4 col-xl-4 col-md-6 col-11">
            <div class="card-block">
                <div class="card-header d_orange text-center white-text z-depth-2">
                    <h1>{{ $t('content.auth.reset_password.title') }}<i class="fa fa-unlock fa-lg fa-right"></i></h1>
                </div>
                <div class="md-form">
                    <i class="fa fa-lock fa-lg prefix"></i>
                    <input type="password" id="forgot-password" class="form-control" v-model="password" @keyup.enter="perform">
                    <label for="forgot-password">{{ $t('content.auth.reset_password.password') }}</label>
                </div>
                <div class="md-form">
                    <i class="fa fa-lock fa-lg prefix"></i>
                    <input type="password" id="forgot-password-confirmation" class="form-control" v-model="passwordConfirmation" @keyup.enter="perform">
                    <label for="forgot-password-confirmation">{{ $t('content.auth.reset_password.password_confirmation') }}</label>
                </div>
                <div class="col-12 text-center">
                    <button class="btn btn-warning btn-lg" @click="perform">{{ $t('content.auth.reset_password.btn') }}</button>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div v-if="accessModeAny || accessModeAuth" class="col-12 text-center">
                        <a :href="routeLogin"><i class="fa fa-plus fa-left"></i>{{ $t('content.auth.signin.title') }}</a>
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
        props: ['accessModeAny', 'accessModeAuth', 'routeLogin', 'routeServers', 'routeResetPassword'],
        data() {
            return {
                password: '',
                passwordConfirmation: ''
            }
        },
        methods: {
            check() {
                return this.password.length !== 0 && this.passwordConfirmation.length !== 0;
            },
            send() {
                axios.post(this.routeResetPassword, {
                    password: this.password,
                    password_confirmation: this.passwordConfirmation,
                })
                    .then((response) => {
                        if (response.data.status === 'success') {
                            Url.redirect(response.data.redirect);
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