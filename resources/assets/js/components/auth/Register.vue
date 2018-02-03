<template>
    <div class="full-h flex-center pd-v-form">
        <div class="card no-pdh z-depth-4 col-xl-4 col-md-6 col-11">
            <div class="card-block">
                <div class="card-header d_orange text-center white-text z-depth-2">
                    <h1>{{ $t('content.auth.register.title') }}<i class="fa fa-sign-in fa-lg fa-right"></i></h1>
                </div>
                <div class="md-form">
                    <i class="fa fa-user fa-lg prefix"></i>
                    <input type="text" id="su-username" class="form-control" v-model="username" @keyup.enter="perform">
                    <label for="su-username">{{ $t('content.all.username') }}</label>
                </div>
                <div class="md-form">
                    <i class="fa fa-envelope fa-lg prefix"></i>
                    <input type="text" id="su-email" class="form-control" v-model="email" @keyup.enter="perform">
                    <label for="su-email">{{ $t('content.all.email') }}</label>
                </div>
                <div class="md-form">
                    <i class="fa fa-unlock-alt fa-lg prefix"></i>
                    <input type="password" id="su-password" class="form-control" v-model="password" @keyup.enter="perform">
                    <label for="su-password">{{ $t('content.all.password') }}</label>
                </div>
                <div class="md-form">
                    <i class="fa fa-unlock-alt fa-lg prefix"></i>
                    <input type="password" id="su-password-confirm" class="form-control" v-model="passwordConfirmation" @keyup.enter="perform">
                    <label for="su-password-confirm">{{ $t('content.all.password_confirmation') }}</label>
                </div>
                <div v-html="captcha" class="md-form"></div>
                <div class="col-12 text-center">
                    <button class="btn btn-warning btn-lg" @click="perform">{{ $t('content.auth.register.btn') }}
                    </button>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div v-if="accessModeAny || accessModeAuth" class="col-12 text-center">
                        <a :href="routeLogin"><i class="fa fa-plus fa-left"></i> {{ $t('content.auth.register.signin') }}</a>
                    </div>
                    <div v-if="accessModeAny" class="col-12 text-center">
                        <a :href="loginServers"><i class="fa fa-shopping-cart"></i> {{ $t('content.auth.signin.guest') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Url from "../../common/url";

    export default {
        props: ['routeRegister', 'accessModeAny', 'accessModeAuth', 'routeLogin', 'loginServers', 'captcha'],
        data() {
            return {
                username: '',
                email: '',
                password: '',
                passwordConfirmation: ''
            }
        },
        methods: {
            check() {
                return this.username.length !== 0 &&
                    this.email.length !== 0 &&
                    this.password.length !== 0 &&
                    this.passwordConfirmation.length !== 0;
            },
            send() {
                axios.post(this.routeRegister, {
                    username: this.username,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.passwordConfirmation,
                    _captcha: captcha.getToken()
                })
                    .then((response) => {
                        grecaptcha.reset();
                        let data = response.data;
                        if (data.status === 'success') {
                            Url.redirect(data.redirect);
                        }
                    })
                    .catch((err) => {
                        grecaptcha.reset();
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
