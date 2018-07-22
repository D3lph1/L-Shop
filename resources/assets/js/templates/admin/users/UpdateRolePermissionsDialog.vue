<template>
    <v-layout row justify-center>
        <v-dialog persistent v-model="dialogData" max-width="800px">
            <v-card>
                <v-card-title class="headline">
                    {{ $t('content.admin.users.roles.update_role_dialog.title', {name}) }}
                </v-card-title>
                <v-card-text>
                    <v-container grid-list-md>
                        <v-form id="form">
                            <div v-if="retrieveLoading" class="text-xs-center">
                                <v-progress-circular
                                        indeterminate
                                        color="primary"
                                ></v-progress-circular>
                            </div>
                            <v-select
                                    v-else
                                    v-model="selected"
                                    :label="$t('content.admin.users.roles.create_role_dialog.permissions')"
                                    chips
                                    tags
                                    :items="permissions"
                            ></v-select>
                        </v-form>
                    </v-container>
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="red" flat round @click.native="dialogData = false">
                        {{ $t('common.cancel') }}
                    </v-btn>
                    <v-btn
                            color="green"
                            flat
                            round
                            :loading="updateLoading"
                            @click="update"
                    >
                        {{ $t('common.update') }}
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-layout>
</template>

<script>
    export default {
        props: {
            dialog: {
                required: true,
                type: Boolean
            },
            id: {
                required: true,
                type: Number
            },
            name: {
                required: true,
                type: String
            },
            permissions: {
                required: true,
                type: Array
            }
        },
        data() {
            return {
                dialogData: this.dialog,
                selected: [],
                retrieveLoading: false,
                updateLoading: false
            }
        },
        mounted() {
            this.retrieveSelectedFromApi();
        },
        watch: {
            dialog(val) {
                this.dialogData = val;
            },
            dialogData(val) {
                if (!val) {
                    this.$emit('close');
                }
            }
        },
        methods: {
            retrieveSelectedFromApi() {
                this.retrieveLoading = true;

                this.$axios.post(`/spa/admin/users/roles/${this.id}/permissions`)
                    .then(response => {
                        if (response.data.status === 'success') {
                            this.selected = response.data.permissions;
                        } else {
                            this.dialogData = false;
                        }
                        this.retrieveLoading = false;
                    })
                    .catch(err => {
                        this.dialogData = false;
                    });
            },
            update() {
                this.updateLoading = true;

                this.$axios.post(`/spa/admin/users/roles/${this.id}/permissions`, {
                    _method: 'PATCH',
                    permissions: this.selected
                })
                    .then(response => {
                        if (response.data.status === 'success') {
                            this.$emit('updated');
                            this.dialogData = false;
                        }
                        this.updateLoading = false;
                    });
            }
        }
    }
</script>
