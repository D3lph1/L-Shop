<template>
    <v-layout row justify-center>
        <v-dialog persistent v-model="dialogData" max-width="500px">
            <v-card>
                <v-card-title class="headline">
                    {{ $t('content.admin.users.roles.create_permission_dialog.title') }}
                </v-card-title>
                <v-card-text>
                    <v-container grid-list-md>
                        <v-layout wrap>
                            <v-text-field
                                    v-model="name"
                                    :label="$t('content.admin.users.roles.create_permission_dialog.name')"
                                    @keyup.enter="create"
                            ></v-text-field>
                        </v-layout>
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
                        {{ $t('content.admin.users.roles.create_permission_dialog.create') }}
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
            }
        },
        data() {
            return {
                dialogData: this.dialog,
                name: '',
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

                this.$axios.post('/spa/admin/users/permissions/create', {
                    name: this.name
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
