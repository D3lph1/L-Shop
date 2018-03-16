<template>
    <v-container fluid grid-list-sm>
        <v-layout row wrap fluid v-if="user !== null">
            <v-flex xs12 sm12 md6>
                <v-card>
                    <v-card-title class="text-xs-center">
                        <h3>{{ $t('content.admin.users.edit.main.title') }}</h3>
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
                        <v-btn flat color="orange" :disabled="finishDisabled" @click="perform">{{ $t('content.admin.users.edit.main.finish') }}</v-btn>
                    </v-card-actions>
                </v-card>
            </v-flex>
            <v-flex xs12 sm12 md6>
                <v-card>
                    <v-card-title class="text-xs-center">
                        <h3>{{ $t('content.admin.users.edit.info.title') }}</h3>
                    </v-card-title>
                    <v-card-text>
                        <v-layout row wrap>
                            <v-expansion-panel>
                                <v-expansion-panel-content>
                                    <div slot="header">{{ $t('common.skin') }}</div>
                                    <v-card class="text-xs-center">
                                        <img :src="user.character.skin.front" alt="Front side of skin">
                                        <img :src="user.character.skin.back" alt="Back side of skin">
                                    </v-card>
                                </v-expansion-panel-content>
                                <v-expansion-panel-content v-if="user.character.cloak.front !== null">
                                    <div slot="header">{{ $t('common.cloak') }}</div>
                                    <v-card class="text-xs-center">
                                        <img :src="user.character.cloak.front" alt="Front side of cloak">
                                        <img :src="user.character.cloak.back" alt="Back side of cloak">
                                    </v-card>
                                </v-expansion-panel-content>
                            </v-expansion-panel>
                        </v-layout>
                    </v-card-text>
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
                password: null,

                user: null,
                roles: null,
                permissions: null,
                finishDisabled: false
            }
        },
        beforeRouteEnter (to, from, next) {
            loader.beforeRouteEnter(`/api/admin/users/edit/${to.params.user}`, to, from, next);
        },
        beforeRouteUpdate (to, from, next) {
            loader.beforeRouteUpdate(`/api/admin/users/edit/${to.params.user}`, to, from, next, this);
        },
        methods: {
            perform() {
                //
            },
            setData(response) {
                const data = response.data;

                this.user = data.user;
                this.roles = data.roles;
                this.permissions = data.permissions;
            }
        }
    }
</script>
