<template>
    <v-layout row justify-center>
        <v-dialog persistent v-model="dialogData" max-width="800px">
            <v-card>
                <v-card-title class="headline">
                    {{ $t('content.admin.users.roles.create_role_dialog.title') }}
                </v-card-title>
                <v-card-text>
                    <v-container grid-list-md>
                            <v-form id="form">
                                <v-text-field
                                        v-model="name"
                                        :label="$t('content.admin.users.roles.create_role_dialog.name')"
                                        @keyup.enter="create"
                                ></v-text-field>

                                <v-select
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
                            :disabled="createDisabled"
                            :loading="createLoading"
                            @click="create"
                    >
                        {{ $t('common.create') }}
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
            permissions: {
                required: true,
                type: Array
            }
        },
        data() {
            return {
                dialogData: this.dialog,
                name: '',
                selected: [],
                createLoading: false
            }
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
        computed: {
            createDisabled() {
                return !this.check();
            }
        },
        methods: {
            check() {
                return this.name !== '';
            },
            create() {
                if (!this.check()) {
                    return;
                }

                this.createLoading = true;

                this.$axios.post('/spa/admin/users/roles/create', {
                    name: this.name,
                    permissions: this.permissions
                })
                    .then(response => {
                        this.createLoading = false;

                        if (response.data.status === 'success') {
                            this.$emit('created');
                            this.dialogData = false;
                        }
                    });
            }
        }
    }
</script>
