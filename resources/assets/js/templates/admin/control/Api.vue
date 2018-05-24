<template>
    <v-layout align-center justify-center>
        <v-flex xs12 sm12 md10 lg8>
            <v-card>
                <v-card-title class="text-xs-center">
                    <h3>{{ $t('content.admin.control.api.title') }}</h3>
                    <v-spacer></v-spacer>
                    <span class="caption" v-html="$t('common.unclear_docs', {link: 'https://github.com/D3lph1/L-shop/wiki'})"></span>
                </v-card-title>
                <v-card-text>
                    <v-subheader>{{ $t('content.admin.control.api.basic') }}</v-subheader>
                    <v-switch
                            color="secondary"
                            class="mt-4"
                            :label="$t('content.admin.control.api.enabled')"
                            v-model="enabled"
                    ></v-switch>
                    <v-text-field
                            :label="$t('content.admin.control.api.key')"
                            v-model="key"
                    ></v-text-field>
                    <v-text-field
                            :label="$t('content.admin.control.api.delimiter')"
                            v-model="delimiter"
                    ></v-text-field>
                    <v-select
                            :items="algorithms"
                            v-model="algorithm"
                            :label="$t('content.admin.control.api.algorithm')"
                    >
                    </v-select>
                    <v-subheader>{{ $t('content.admin.control.api.functions') }}</v-subheader>
                    <v-subheader inset>{{ $t('content.admin.control.api.auth') }}</v-subheader>
                    <v-switch
                            color="secondary"
                            class="mt-4"
                            :label="$t('content.admin.control.api.auth_enabled')"
                            v-model="authEnabled"
                    ></v-switch>
                    <v-switch
                            color="secondary"
                            :label="$t('content.admin.control.api.register_enabled')"
                            v-model="registerEnabled"
                    ></v-switch>
                    <v-subheader inset>{{ $t('content.admin.control.api.sashok724s_launcher.title') }}</v-subheader>
                    <v-switch
                            color="secondary"
                            class="mt-4"
                            :label="$t('content.admin.control.api.sashok724s_launcher.enabled')"
                            v-model="sashok724sV3LauncherEnabled"
                    ></v-switch>
                    <v-text-field
                            :label="$t('content.admin.control.api.sashok724s_launcher.format')"
                            v-model="sashok724sV3LauncherFormat"
                    ></v-text-field>
                    <v-select
                            :label="$t('content.admin.control.api.sashok724s_launcher.ips')"
                            chips
                            tags
                            clearable
                            v-model="sashok724sV3LauncherIPs"
                    >
                    </v-select>
                </v-card-text>
                <v-card-actions>
                    <v-btn flat color="primary" :loading="finishLoading" @click="perform">{{ $t('common.save') }}</v-btn>
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
                enabled: false,
                key: '',
                delimiter: '',
                algorithm: null,
                algorithms: [
                    'md5',
                    'sha224',
                    'sha256',
                    'sha385',
                    'sha512',
                    'whirlpool'
                ],
                authEnabled: false,
                registerEnabled: false,
                sashok724sV3LauncherEnabled: false,
                sashok724sV3LauncherFormat: [],
                sashok724sV3LauncherIPs: [],
                finishLoading: false
            }
        },
        beforeRouteEnter (to, from, next) {
            loader.beforeRouteEnter('/spa/admin/control/api', to, from, next);
        },
        beforeRouteUpdate (to, from, next) {
            loader.beforeRouteUpdate('/spa/admin/control/api', to, from, next, this);
        },
        methods: {
            perform() {
                this.finishLoading = true;
                this.$axios.post('/spa/admin/control/api', {
                    enabled: this.enabled,
                    key: this.key,
                    delimiter: this.delimiter,
                    algorithm: this.algorithm,
                    auth_enabled: this.authEnabled,
                    register_enabled: this.registerEnabled,
                    sashok724sV3_launcher_enabled: this.sashok724sV3LauncherEnabled,
                    sashok724sV3_launcher_format: this.sashok724sV3LauncherFormat,
                    sashok724sV3_launcher_IPs: this.sashok724sV3LauncherIPs,
                })
                    .then(response => {
                        this.finishLoading = false;
                    });
            },
            setData(response) {
                const data = response.data;

                this.enabled = data.apiEnabled;
                this.key = data.key;
                this.delimiter = data.delimiter;
                this.algorithm = data.algorithm;
                this.authEnabled = data.apiAuthEnabled;
                this.registerEnabled = data.apiRegisterEnabled;
                this.sashok724sV3LauncherEnabled = data.sashok724sV3LauncherEnabled;
                this.sashok724sV3LauncherFormat = data.sashok724sV3LauncherFormat;
                this.sashok724sV3LauncherIPs = data.sashok724sV3LauncherIPs;
            }
        }
    }
</script>
