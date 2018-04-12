<template>
    <v-container fluid grid-list-sm>
        <v-layout row wrap fluid>
            <v-flex xs12 sm12 md6>
                <v-card>
                    <v-card-title class="text-xs-center">
                        <h3>{{ $t('content.admin.control.basic.title') }}</h3>
                        <v-spacer></v-spacer>
                        <span class="caption" v-html="$t('common.unclear_docs', {link: 'https://github.com/D3lph1/L-shop/wiki'})"></span>
                    </v-card-title>
                    <v-card-text>
                        <v-subheader>{{ $t('content.admin.control.basic.basic_section') }}</v-subheader>
                        <v-text-field
                                :label="$t('content.admin.control.basic.name')"
                                v-model="name"
                        ></v-text-field>
                        <v-text-field
                                :label="$t('content.admin.control.basic.description')"
                                v-model="description"
                                multi-line
                        ></v-text-field>

                        <v-select
                                :label="$t('content.admin.control.basic.keywords')"
                                chips
                                tags
                                clearable
                                v-model="keywords"
                        >
                            <template slot="selection" slot-scope="data">
                                <v-chip
                                        close
                                        @input="removeItem(data.item, keywords)"
                                        :selected="data.selected"
                                >
                                    <strong>{{ data.item }}</strong>
                                </v-chip>
                            </template>
                        </v-select>

                        <v-subheader class="mt-4">{{ $t('content.admin.control.basic.users_section') }}</v-subheader>
                        <v-select
                                :items="accessModeItems"
                                v-model="accessMode"
                                :hint="$t('content.admin.control.basic.access_mode.title')"
                                persistent-hint
                                single-line
                        ></v-select>
                        <v-switch
                                color="secondary"
                                class="mt-4"
                                :label="$t('content.admin.control.basic.enable_register')"
                                v-model="registerEnabled"
                        ></v-switch>
                        <v-switch
                                color="secondary"
                                :label="$t('content.admin.control.basic.enable_send_activations')"
                                v-model="sendActivationEnabled"
                        ></v-switch>
                        <v-layout align-center>
                            <v-checkbox
                                    color="secondary"
                                    v-model="customRedirectAfterRegistrationEnabled"
                                    hide-details class="shrink mr-2"
                            ></v-checkbox>
                            <v-text-field
                                    :label="$t('content.admin.control.basic.custom_url_after_register')"
                                    v-model="customRedirectAfterRegistrationUrl"
                                    :disabled="!customRedirectAfterRegistrationEnabled"
                            ></v-text-field>
                        </v-layout>

                        <v-subheader class="mt-4">{{ $t('content.admin.control.basic.skin_cloak_section') }}</v-subheader>
                        <v-switch
                                color="secondary"
                                :label="$t('content.admin.control.basic.skin_enabled')"
                                class="mt-3"
                                v-model="skinEnabled"
                        ></v-switch>
                        <v-select
                                :label="$t('content.admin.control.basic.skin_sizes')"
                                chips
                                tags
                                clearable
                                v-model="skinSizes"
                                :rules="[validateImageSize(skinSizes)]"
                        >
                            <template slot="selection" slot-scope="data">
                                <v-chip
                                        close
                                        @input="removeItem(data.item, skinSizes)"
                                        :selected="data.selected"
                                >
                                    <strong>{{ data.item }}</strong>
                                </v-chip>
                            </template>
                        </v-select>
                        <v-switch
                                color="secondary"
                                :label="$t('content.admin.control.basic.hd_skin_enabled')"
                                class="mt-3"
                                v-model="hdSkinEnabled"
                        ></v-switch>
                        <v-select
                                :label="$t('content.admin.control.basic.skin_sizes_hd')"
                                chips
                                tags
                                clearable
                                v-model="skinSizesHd"
                                :rules="[validateImageSize(skinSizesHd)]"
                        >
                            <template slot="selection" slot-scope="data">
                                <v-chip
                                        close
                                        @input="removeItem(data.item, skinSizesHd)"
                                        :selected="data.selected"
                                >
                                    <strong>{{ data.item }}</strong>
                                </v-chip>
                            </template>
                        </v-select>
                        <v-switch
                                color="secondary"
                                :label="$t('content.admin.control.basic.cloak_enabled')"
                                class="mt-3"
                                v-model="cloakEnabled"
                        ></v-switch>
                        <v-select
                                :label="$t('content.admin.control.basic.cloak_sizes')"
                                chips
                                tags
                                clearable
                                v-model="cloakSizes"
                                :rules="[validateImageSize(cloakSizes)]"
                        >
                            <template slot="selection" slot-scope="data">
                                <v-chip
                                        close
                                        @input="removeItem(data.item, cloakSizes)"
                                        :selected="data.selected"
                                >
                                    <strong>{{ data.item }}</strong>
                                </v-chip>
                            </template>
                        </v-select>
                        <v-switch
                                color="secondary"
                                :label="$t('content.admin.control.basic.hd_cloak_enabled')"
                                class="mt-3"
                                v-model="hdCloakEnabled"
                        ></v-switch>
                        <v-select
                                :label="$t('content.admin.control.basic.cloak_sizes_hd')"
                                chips
                                tags
                                clearable
                                v-model="cloakSizesHd"
                                :rules="[validateImageSize(cloakSizesHd)]"
                        >
                            <template slot="selection" slot-scope="data">
                                <v-chip
                                        close
                                        @input="removeItem(data.item, cloakSizesHd)"
                                        :selected="data.selected"
                                >
                                    <strong>{{ data.item }}</strong>
                                </v-chip>
                            </template>
                        </v-select>
                        <v-layout row wrap>
                            <v-flex xs12 md6>
                                <v-text-field
                                        :label="$t('content.admin.control.basic.max_skin_file_size')"
                                        v-model="maxSkinFileSize"
                                        type="number"
                                        class="no-spinners"
                                ></v-text-field>
                            </v-flex>
                            <v-flex xs12 md6>
                                <v-text-field
                                        :label="$t('content.admin.control.basic.max_cloak_file_size')"
                                        v-model="maxCloakFileSize"
                                        type="number"
                                        class="no-spinners"
                                ></v-text-field>
                            </v-flex>
                        </v-layout>
                    </v-card-text>
                </v-card>
            </v-flex>
            <v-flex xs12 sm12 md6>
                <v-card>
                    <v-card-text>
                        <v-subheader>{{ $t('content.admin.control.basic.catalog_section') }}</v-subheader>
                        <v-text-field
                                :label="$t('content.admin.control.basic.catalog_per_page')"
                                v-model="catalogPerPage"
                                type="number"
                                class="no-spinners"
                        ></v-text-field>
                        <v-select
                                :items="sortProductsItems"
                                v-model="sortProducts"
                                return-object
                                item-value="value.value"
                                :hint="$t('content.admin.control.basic.sort_products.title')"
                                persistent-hint
                                single-line
                        ></v-select>

                        <v-subheader class="mt-5">{{ $t('content.admin.control.basic.news_section') }}</v-subheader>
                        <v-switch
                                color="secondary"
                                :label="$t('content.admin.control.basic.news_enabled')"
                                class="mt-3"
                                v-model="newsEnabled"
                        ></v-switch>
                        <v-text-field
                                :label="$t('content.admin.control.basic.news_per_portion')"
                                v-model="newsPerPortion"
                                type="number"
                                class="no-spinners"
                        ></v-text-field>

                        <v-subheader class="mt-5">{{ $t('content.admin.control.basic.monitoring_section') }}</v-subheader>
                        <v-switch
                                color="secondary"
                                :label="$t('content.admin.control.basic.monitoring_enabled')"
                                class="mt-3"
                                v-model="monitoringEnabled"
                        ></v-switch>
                        <v-text-field
                                :label="$t('content.admin.control.basic.monitoring_rcon_timeout')"
                                v-model="monitoringRconTimeout"
                                type="number"
                                class="no-spinners"
                        ></v-text-field>
                        <v-text-field
                                :label="$t('content.admin.control.basic.monitoring_rcon_command')"
                                v-model="monitoringRconCommand"
                                class="no-spinners"
                        ></v-text-field>
                        <v-text-field
                                :label="$t('content.admin.control.basic.monitoring_rcon_response_pattern')"
                                v-model="monitoringRconResponsePattern"
                                class="no-spinners"
                        ></v-text-field>

                        <v-subheader class="mt-5">{{ $t('content.admin.control.basic.service_section') }}</v-subheader>
                        <v-switch
                                color="secondary"
                                :label="$t('content.admin.control.basic.maintenance_mode_enabled')"
                                class="mt-3"
                                v-model="maintenanceMode"
                        ></v-switch>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn flat color="orange" :loading="finishLoading" :disabled="finishDisabled" @click="perform">{{ $t('common.save') }}</v-btn>
                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    import loader from './../../../core/http/loader'

    export default {
        data() {
            return {
                name: '',
                description: '',
                keywords: [],
                accessMode: null,
                accessModeItems: [
                    { text: $t('content.admin.control.basic.access_mode.guest'), value: 'guest' },
                    { text: $t('content.admin.control.basic.access_mode.auth'), value: 'auth' },
                    { text: $t('content.admin.control.basic.access_mode.any'), value: 'any' }
                ],
                registerEnabled: false,
                sendActivationEnabled: false,
                customRedirectAfterRegistrationEnabled: false,
                customRedirectAfterRegistrationUrl: '',
                skinEnabled: false,
                hdSkinEnabled: false,
                cloakEnabled: false,
                hdCloakEnabled: false,
                maxSkinFileSize: 0,
                maxCloakFileSize: 0,
                skinSizes: [],
                skinSizesHd: [],
                cloakSizes: [],
                cloakSizesHd: [],

                catalogPerPage: 0,
                sortProducts: null,
                sortProductsItems: [
                    {text: $t('content.admin.control.basic.sort_products.by_name'), value: {by: 'item.name', descending: false, value: 'item.name:false'}},
                    {text: $t('content.admin.control.basic.sort_products.by_name_desc'), value: {by: 'item.name', descending: true, value: 'item.name:true'}},
                    {text: $t('content.admin.control.basic.sort_products.by_priority'), value: {by: 'product.sortPriority', descending: false, value: 'product.sortPriority:false'}},
                    {text: $t('content.admin.control.basic.sort_products.by_priority_desc'), value: {by: 'product.sortPriority', descending: true, value: 'product.sortPriority:true'}}
                ],
                newsEnabled: false,
                newsPerPortion: 0,
                monitoringEnabled: false,
                monitoringRconTimeout: 0,
                monitoringRconCommand: 0,
                monitoringRconResponsePattern: 0,
                maintenanceMode: false,

                finishDisabled: false,
                finishLoading: false
            }
        },
        beforeRouteEnter (to, from, next) {
            loader.beforeRouteEnter('/api/admin/control/basic', to, from, next);
        },
        beforeRouteUpdate (to, from, next) {
            loader.beforeRouteUpdate('/api/admin/control/basic', to, from, next, this);
        },
        methods: {
            removeItem(target, from) {
                from.splice(from.indexOf(target), 1);
                from = [...from];
            },
            validateImageSize(items) {
                let result = true;

                items.forEach(item => {
                    if (!item.match(/^[0-9]{1,4}x[1-9]{1,4}$/)) {
                        result = $t('common.invalid_format');
                    }
                });

                return result;
            },
            perform() {
                this.finishLoading = true;

                function normalizeSizes(src) {
                    let result = [];

                    src.forEach(item => {
                        const sizes = item.match(/^([0-9]{1,4})x([1-9]{1,4})$/);
                        result.push([Number(sizes[1]), Number(sizes[2])]);
                    });

                    return result;
                }


                this.$axios.post('/api/admin/control/basic', {
                    name: this.name,
                    description: this.description,
                    keywords: this.keywords,
                    access_mode: this.accessMode,
                    register_enabled: this.registerEnabled,
                    send_activation_enabled: this.sendActivationEnabled,
                    custom_redirect_enabled: this.customRedirectAfterRegistrationEnabled,
                    custom_redirect_url: this.customRedirectAfterRegistrationUrl,
                    skin_enabled: this.skinEnabled,
                    skin_max_file_size: this.maxSkinFileSize,
                    skin_list: normalizeSizes(this.skinSizes),
                    skin_hd_enabled: this.hdSkinEnabled,
                    skin_hd_list: normalizeSizes(this.skinSizesHd),
                    cloak_enabled: this.cloakEnabled,
                    cloak_max_file_size: this.maxCloakFileSize,
                    cloak_list: normalizeSizes(this.cloakSizes),
                    cloak_hd_enabled: this.hdCloakEnabled,
                    cloak_hd_list: normalizeSizes(this.cloakSizesHd),
                    catalog_per_page: this.catalogPerPage,
                    sort_products_by: this.sortProducts.value.by,
                    sort_products_descending: this.sortProducts.value.descending,
                    news_enabled: this.newsEnabled,
                    news_per_portion: this.newsPerPortion,
                    monitoring_enabled: this.monitoringEnabled,
                    monitoring_rcon_timeout: this.monitoringRconTimeout,
                    monitoring_rcon_command: this.monitoringRconCommand,
                    monitoring_rcon_response_pattern: this.monitoringRconResponsePattern,
                    maintenance_mode: this.maintenanceMode,
                })
                    .then(response => {
                        this.finishLoading = false;
                        this.$router.push({query: {update: Math.random()}});
                    });
            },
            setData(response) {
                const data = response.data;

                this.name = data.name;
                this.description = data.description;
                this.keywords = data.keywords;
                this.accessMode = data.accessMode;
                this.registerEnabled = data.registerEnabled;
                this.sendActivationEnabled = data.sendActivationEnabled;
                this.customRedirectAfterRegistrationEnabled = data.customRedirectAfterRegistrationEnabled;
                this.customRedirectAfterRegistrationUrl = data.customRedirectAfterRegistrationUrl;
                this.maxSkinFileSize = data.maxSkinFileSize;
                this.maxCloakFileSize = data.maxCloakFileSize;

                this.skinSizes = [];
                data.skinSizes.forEach(item => {
                    this.skinSizes.push(`${item[0]}x${item[1]}`);
                });
                this.skinSizesHd = [];
                data.skinSizesHd.forEach(item => {
                    this.skinSizesHd.push(`${item[0]}x${item[1]}`);
                });
                this.cloakSizes = [];
                data.cloakSizes.forEach(item => {
                    this.cloakSizes.push(`${item[0]}x${item[1]}`);
                });
                this.cloakSizesHd = [];
                data.cloakSizesHd.forEach(item => {
                    this.cloakSizesHd.push(`${item[0]}x${item[1]}`);
                });

                this.skinEnabled = data.skinEnabled;
                this.hdSkinEnabled = data.hdSkinEnabled;
                this.cloakEnabled = data.cloakEnabled;
                this.hdCloakEnabled = data.hdCloakEnabled;

                this.catalogPerPage = data.catalogPerPage;
                this.sortProducts = {
                    text: null,
                    value: {
                        by: data.sortProductsBy,
                        descending: data.sortProductsDescending,
                        value: `${data.sortProductsBy}:${data.sortProductsDescending}`
                    }
                };

                this.newsEnabled = data.newsEnabled;
                this.newsPerPortion = data.newsPerPortion;
                this.monitoringEnabled = data.monitoringEnabled;
                this.monitoringRconTimeout = data.monitoringRconTimeout;
                this.monitoringRconCommand = data.monitoringRconCommand;
                this.monitoringRconResponsePattern = data.monitoringRconResponsePattern;

                this.maintenanceMode = data.maintenanceMode;
            }
        }
    }
</script>
