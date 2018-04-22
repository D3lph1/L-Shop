<template>
    <v-layout align-center justify-center>
        <v-flex xs12 sm12 md10 lg8>
            <v-card>
                <v-card-title class="text-xs-center">
                    <h3>{{ $t('content.frontend.profile.settings.title') }}</h3>
                </v-card-title>
                <v-card-text>
                    <v-subheader inset>{{ $t('content.frontend.profile.settings.password_change.title') }}</v-subheader>
                    <v-text-field type="password" v-model="newPassword"
                                  :label="$t('content.frontend.profile.settings.password_change.new')"
                                  prepend-icon="lock"></v-text-field>
                    <v-text-field type="password" v-model="newPasswordConfirmation"
                                  :label="$t('content.frontend.profile.settings.password_change.new_confirmation')"
                                  prepend-icon="lock"></v-text-field>
                    <div class="text-xs-center">
                        <v-btn color="primary" :loading="passwordChangeLoading" :disabled="passwordChangeDisabled()"
                               @click="passwordChange">{{ $t('common.save') }}
                        </v-btn>
                    </div>
                    <v-subheader inset>{{ $t('content.frontend.profile.settings.login_reset.title') }}</v-subheader>
                    <p>{{ $t('content.frontend.profile.settings.login_reset.description') }}</p>
                    <div class="text-xs-center">
                        <v-btn color="error" :loading="resetSessionsLoading" @click="resetLoginSessions">{{
                            $t('content.frontend.profile.settings.login_reset.reset') }}
                        </v-btn>
                    </div>
                </v-card-text>
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
    export default {
        data() {
            return {
                newPassword: null,
                newPasswordConfirmation: null,
                passwordChangeLoading: false,
                resetSessionsLoading: false
            }
        },
        methods: {
            passwordChangeDisabled() {
                return this.newPassword === null ||
                    this.newPassword === '' ||
                    this.newPasswordConfirmation === null ||
                    this.newPasswordConfirmation === '';
            },
            passwordChange() {
                this.passwordChangeLoading = true;
                this.$axios.post('/spa/profile/settings/password', {
                    password: this.newPassword,
                    password_confirmation: this.newPasswordConfirmation
                })
                    .then(response => {
                        if (response.data.status === 'success') {
                            this.newPassword = null;
                            this.newPasswordConfirmation = null;
                            this.passwordChangeLoading = false;
                        }
                    })
                    .catch(err => {
                        this.passwordChangeLoading = false;
                    });
            },
            resetLoginSessions() {
                this.resetSessionsLoading = true;
                this.$axios.post('/spa/profile/settings/sessions/reset', {
                    password: this.newPassword,
                    password_confirmation: this.newPasswordConfirmation
                })
                    .then(response => {
                        if (response.data.status === 'success') {
                            this.$router.push({name: 'frontend.auth.login'});
                        }
                    });
            }
        }
    }
</script>