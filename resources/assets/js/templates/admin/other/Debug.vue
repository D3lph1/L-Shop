<template>
    <v-layout align-center justify-center>
        <v-flex xs12 sm12 md10 lg8>
            <v-card>
                <v-card-title class="text-xs-center">
                    <h3>{{ $t('content.admin.other.debug.title') }}</h3>
                    <v-spacer></v-spacer>
                    <span class="caption" v-html="$t('common.unclear_docs', {link: 'https://github.com/D3lph1/L-shop/wiki'})"></span>
                </v-card-title>
                <v-card-text>
                    <v-subheader>{{ $t('content.admin.other.debug.email.title') }}</v-subheader>
                    <v-container>{{ $t('content.admin.other.debug.email.description') }}</v-container>
                    <v-text-field
                            v-model="email"
                            :label="$t('content.admin.other.debug.email.address')"
                            :rules="[validateEmail]"
                            prepend-icon="mail_outline"
                    ></v-text-field>
                    <v-alert type="success" outline :value="success">{{ $t('content.admin.other.debug.email.success') }}</v-alert>
                    <v-alert type="error" outline :value="failure !== null">
                        <p>{{ $t('content.admin.other.debug.email.failure') }}</p>
                        <p>{{ failure }}</p>
                    </v-alert>
                    <v-btn
                            color="secondary"
                            :disabled="emailDisabled"
                            :loading="emailLoading"
                            @click="sendTestEmail"
                    >{{ $t('common.send') }}</v-btn>
                </v-card-text>
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
    import loader from './../../../core/http/loader'

    export default {
        data() {
            return {
                email: '',
                success: false,
                failure: null,
                emailDisabled: false,
                emailLoading: false
            }
        },
        beforeRouteEnter (to, from, next) {
            loader.beforeRouteEnter('/spa/admin/other/debug', to, from, next);
        },
        beforeRouteUpdate (to, from, next) {
            loader.beforeRouteUpdate('/spa/admin/other/debug', to, from, next, this);
        },
        methods: {
            validateEmail() {
                if (this.email.match(/.+@.+\..+/i)) {
                    this.emailDisabled = false;

                    return true;
                }
                this.emailDisabled = true;

                return  $t('content.admin.other.debug.email.invalid_address');
            },
            sendTestEmail() {
                this.emailLoading = true;
                this.$axios.post('/spa/admin/other/debug/send', {
                    email: this.email
                })
                    .then(response => {
                        this.emailLoading = false;
                        if (response.data.status === 'success') {
                            this.success = true;
                            this.failure = null;
                        } else if (response.data.status === 'failure') {
                            this.success = false;
                            this.failure = response.data.message;
                        }
                    });
            },
            setData(response) {
                //
            }
        }
    }
</script>
