<template>
    <div class="full-h flex-center pd-v-form">
        <div class="card no-pdh z-depth-4 col-xl-4 col-md-6 col-11">
            <div class="card-block">
                <div class="card-header d_orange text-center white-text z-depth-2">
                    <h1>{{ $t('content.auth.forgot.title') }}<i class="fa fa-unlock fa-lg fa-right"></i></h1>
                </div>
                <div class="md-form">
                    <i class="fa fa-envelope fa-lg prefix"></i>
                    <input type="text" id="forgot-email" class="form-control" v-model="email" @keyup.enter="perform">
                    <label for="forgot-email">{{ $t('content.all.email') }}</label>
                </div>
                <div v-html="captcha" class="md-form"></div>
                <div class="col-12 text-center">
                    <button class="btn btn-warning btn-lg" @click="perform">{{ $t('content.auth.forgot.btn') }}</button>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div v-if="accessModeAny || accessModeAuth" class="col-12 text-center">
                        <a :href="routeLogin"><i class="fa fa-plus fa-left"></i> {{ $t('content.auth.signin.title') }}</a>
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
        props: ['accessModeAny', 'accessModeAuth', 'routeLogin', 'routeServers', 'routeForgotPassword', 'captcha'],
        data() {
            return {
                email: ''
            }
        },
        methods: {
            check() {
                this.email = this.email.trim();

                return this.email.length !== 0;
            },
            send() {
                axios.post(this.routeForgotPassword, {
                    email: this.email,
                    _captcha: captcha.getToken()
                })
                    .then((response) => {
                        grecaptcha.reset();
                        if (response.data.status === 'success') {
                            Url.redirect(response.data.redirect);
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
