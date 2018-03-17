<template>
    <v-container fluid grid-list-sm>
        <v-layout row wrap fluid v-if="user !== null">
            <v-flex xs12 sm12 md6>
                <v-card>
                    <v-card-title class="text-xs-center">
                        <h3>{{ $t('content.admin.users.edit.main.title') }}</h3>
                        <v-spacer></v-spacer>
                        <span class="caption" v-html="$t('common.unclear_docs', {link: 'https://github.com/D3lph1/L-shop/wiki'})"></span>
                    </v-card-title>
                    <v-card-text>
                        <v-text-field
                                v-model="user.username"
                                prepend-icon="person"
                                :label="$t('common.username')"
                        ></v-text-field>
                        <v-text-field
                                v-model="user.email"
                                prepend-icon="email"
                                :label="$t('common.email')"
                        ></v-text-field>
                        <v-text-field
                                type="password"
                                v-model="password"
                                prepend-icon="lock"
                                :label="$t('content.admin.users.edit.main.new_password')"
                        ></v-text-field>
                        <v-select
                                v-model="user.roles"
                                :label="$t('content.admin.users.edit.main.roles')"
                                chips
                                tags
                                :items="roles"
                        ></v-select>
                        <v-select
                                v-model="user.permissions"
                                :label="$t('content.admin.users.edit.main.permissions')"
                                chips
                                tags
                                :items="permissions"
                        ></v-select>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn flat color="orange" :loading="finishLoading" :disabled="finishDisabled" @click="perform">{{ $t('content.admin.users.edit.main.finish') }}</v-btn>
                    </v-card-actions>
                </v-card>
            </v-flex>
            <v-flex xs12 sm12 md6>
                <v-card>
                    <v-card-title class="text-xs-center">
                        <h3>{{ $t('content.admin.users.edit.actions.title') }}</h3>
                    </v-card-title>
                    <v-card-text>
                        <v-layout row wrap>
                            <v-expansion-panel>
                                <v-expansion-panel-content>
                                    <div slot="header">{{ $t('common.skin') }}</div>
                                    <v-card class="text-xs-center">
                                        <img :src="user.character.skin.front" alt="Front side of skin">
                                        <img :src="user.character.skin.back" alt="Back side of skin">

                                        <v-container>
                                            <v-layout row wrap>
                                                <v-flex xs12 class="text-xs-center mt-2">
                                                    <v-uploader class="uploader" accept="image/png" :reset="skin.upload === null" @formData="setUploadableSkin"></v-uploader>
                                                </v-flex>
                                                <v-flex xs12 class="text-xs-center mt-2">
                                                    <v-btn color="success" :disabled="uploadSkinDisabled" :loading="skin.uploadLoading" @click="uploadSkin">{{ $t('content.frontend.profile.character.upload') }}</v-btn>
                                                    <v-btn color="error" :disabled="user.character.skin.default" :loading="skin.deleteLoading" @click="deleteSkin"><v-icon>delete</v-icon></v-btn>
                                                </v-flex>
                                            </v-layout>
                                        </v-container>
                                    </v-card>
                                </v-expansion-panel-content>
                                <v-expansion-panel-content>
                                    <div slot="header">{{ $t('common.cloak') }}</div>
                                    <v-card class="text-xs-center">
                                        <div v-if="user.character.cloak.exists">
                                            <img :src="user.character.cloak.front" alt="Front side of cloak">
                                            <img :src="user.character.cloak.back" alt="Back side of cloak">
                                        </div>

                                        <v-container>
                                            <v-alert v-if="!user.character.cloak.exists" type="info" outline :value="true">{{ $t('content.frontend.profile.character.cloak.not_set') }}</v-alert>
                                            <v-layout row wrap>
                                                <v-flex xs12 class="text-xs-center mt-2">
                                                    <v-uploader class="uploader" accept="image/png" :reset="cloak.upload === null" @formData="setUploadableCloak"></v-uploader>
                                                </v-flex>
                                                <v-flex xs12 class="text-xs-center mt-2">
                                                    <v-btn color="success" :disabled="uploadCloakDisabled" :loading="cloak.uploadLoading" @click="uploadCloak">{{ $t('content.frontend.profile.character.upload') }}</v-btn>
                                                    <v-btn color="error" :disabled="!user.character.cloak.exists" :loading="cloak.deleteLoading" @click="deleteCloak"><v-icon>delete</v-icon></v-btn>
                                                </v-flex>
                                            </v-layout>
                                        </v-container>
                                    </v-card>
                                </v-expansion-panel-content>
                            </v-expansion-panel>
                        </v-layout>
                        <v-layout row wrap>
                            <v-flex xs12 class="text-xs-center">
                                <v-alert type="success" outline :value="true">
                                    <span v-html="$t('content.admin.users.edit.actions.activated_at', {datetime: `<i>${user.activatedAt}</i>`})"></span>
                                </v-alert>
                            </v-flex>
                            <v-flex xs12 class="text-xs-center" v-if="user.banned">
                                <v-alert type="error" outline :value="true">{{ $t('content.admin.users.edit.actions.banned') }}</v-alert>
                            </v-flex>
                            <v-flex xs12 class="text-xs-center" v-if="user.bans.length !== 0">
                                <v-btn color="error" flat @click="bansHistoryDialog = true">{{ $t('content.admin.users.edit.actions.show_bans_history') }}</v-btn>
                                <bans-history
                                        :dialog="bansHistoryDialog"
                                        :username="user.username"
                                        :bans="user.bans"
                                        @close="closeBansHistoryDialog"
                                        @update="updateBans"
                                ></bans-history>
                            </v-flex>
                            <v-flex xs12 class="text-xs-center" >
                                <v-btn color="error" flat @click="addBanDialog = true">
                                    <span v-if="user.bans.length === 0">{{ $t('content.admin.users.edit.actions.show_ban_dialog') }}</span>
                                    <span v-else>{{ $t('content.admin.users.edit.actions.show_add_ban_dialog') }}</span>
                                </v-btn>
                                <add-ban-dialog
                                        :dialog="addBanDialog"
                                        :firstBan="user.bans.length === 0"
                                        :user-id="user.id"
                                        @close="closeAddBanDialog"
                                        @add="addBan"
                                ></add-ban-dialog>
                            </v-flex>
                        </v-layout>
                    </v-card-text>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    import loader from './../../../core/http/loader'
    import datetime from './../../../core/common/datetime'
    import BansHistory from './BansHistoryDialog.vue'
    import AddBanDialog from './AddBanDialog.vue'

    export default {
        data() {
            return {
                password: null,

                user: null,
                roles: null,
                permissions: null,
                finishDisabled: false,
                finishLoading: false,
                bansHistoryDialog: false,
                addBanDialog: false,

                skin: {
                    upload: null,
                    uploadLoading: false,
                    deleteLoading: false
                },
                cloak: {
                    upload: null,
                    uploadLoading: false,
                    deleteLoading: false
                }
            }
        },
        beforeRouteEnter (to, from, next) {
            loader.beforeRouteEnter(`/api/admin/users/edit/${to.params.user}`, to, from, next);
        },
        beforeRouteUpdate (to, from, next) {
            loader.beforeRouteUpdate(`/api/admin/users/edit/${to.params.user}`, to, from, next, this);
        },
        computed: {
            uploadSkinDisabled() {
                return this.skin.upload === null || this.skin.upload.get('file') === null;
            },
            uploadCloakDisabled() {
                return this.cloak.upload === null || this.cloak.upload.get('file') === null;
            },
        },
        methods: {
            setUploadableSkin(form) {
                this.skin.upload = form;
            },
            setUploadableCloak(form) {
                this.cloak.upload = form;
            },
            uploadSkin() {
                this.skin.uploadLoading = true;
                this.$axios.post(`/api/admin/users/edit/${this.user.id}/skin`, this.skin.upload, {headers: { 'content-type': 'multipart/form-data' }})
                    .then(response => {
                        this.skin.uploadLoading = false;
                        if (response.data.status === 'success') {
                            this.user.character.skin.default = false;
                            this.changeSkin();
                        }
                        this.skin.upload = null;
                    });
            },
            deleteSkin() {
                this.skin.deleteLoading = true;
                this.$axios.post(`/api/admin/users/edit/${this.user.id}/skin`, {
                    _method: 'DELETE'
                })
                    .then(response => {
                        this.skin.deleteLoading = false;
                        if (response.data.status === 'success') {
                            this.user.character.skin.default = true;
                            this.changeSkin();
                        }
                    });
            },
            uploadCloak() {
                this.cloak.uploadLoading = true;
                this.$axios.post(`/api/admin/users/edit/${this.user.id}/cloak`, this.cloak.upload, {headers: { 'content-type': 'multipart/form-data'}})
                    .then(response => {
                        this.cloak.uploadLoading = false;
                        if (response.data.status === 'success') {
                            this.user.character.cloak.exists = true;
                            this.changeCloak();
                        }
                        this.cloak.upload = null;
                    });
            },
            deleteCloak() {
                this.cloak.deleteLoading = true;
                this.$axios.post(`/api/admin/users/edit/${this.user.id}/cloak`, {
                    _method: 'DELETE'
                })
                    .then(response => {
                        this.cloak.deleteLoading = false;
                        if (response.data.status === 'success') {
                            this.user.character.cloak.exists = false;
                            this.changeCloak();
                        }
                    });
            },
            changeSkin() {
                this.user.character.skin.front = `${this.user.character.skin.front}?${Math.random()}`;
                this.user.character.skin.back = `${this.user.character.skin.back}?${Math.random()}`;
            },
            changeCloak() {
                this.user.character.cloak.front = `${this.user.character.cloak.front}?${Math.random()}`;
                this.user.character.cloak.back = `${this.user.character.cloak.back}?${Math.random()}`;
            },
            closeBansHistoryDialog() {
                this.bansHistoryDialog = false;
            },
            closeAddBanDialog() {
                this.addBanDialog = false;
            },
            updateBans(bans) {
                this.user.bans = bans;
                let f = false;
                this.user.bans.forEach(ban => {
                    if (!ban.expired) {
                        f = true;
                    }
                });

                if (this.user.bans.length === 0) {
                    this.bansHistoryDialog = false;
                }

                if (!f) {
                    this.user.banned = false;
                }
            },
            addBan(ban) {
                this.user.bans.push(ban);
                if (!ban.expired) {
                    this.user.banned = true;
                }
            },
            perform() {
                this.finishLoading = true;
                this.$axios.post(`/api/admin/users/edit/${this.user.id}`, {
                    username: this.user.username,
                    email: this.user.email,
                    password: this.password,
                    roles: this.user.roles,
                    permissions: this.user.permissions,
                })
                    .then(response => {
                        this.finishLoading = false;
                        if (response.data.status === 'success') {
                            this.$router.push({name: 'admin.users.list'});
                        }
                    });
            },
            setData(response) {
                const data = response.data;

                this.user = data.user;
                this.user.activatedAt = datetime.localize(data.user.activatedAt);
                this.roles = data.roles;
                this.permissions = data.permissions;
            }
        },
        components: {
            'bans-history': BansHistory,
            'add-ban-dialog': AddBanDialog
        }
    }
</script>
