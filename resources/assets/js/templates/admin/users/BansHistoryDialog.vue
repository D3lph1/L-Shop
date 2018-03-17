<template>
    <v-layout row justify-center>
        <v-dialog v-model="dialogData" max-width="700px">
            <v-card>
                <v-card-title>
                    <span class="headline">{{ $t('content.admin.users.edit.actions.bans_history.title', {username}) }}</span>
                </v-card-title>
                <v-card-text>
                    <v-container grid-list-md>
                        <v-data-table
                                :headers="headers"
                                :items="items"
                                hide-actions
                        >
                            <template slot="items" slot-scope="props">
                                <td :class="'text-xs-center' + (!props.item.expired ? ' not-expired' : '')">{{ localizeDatetime(props.item.createdAt) }}</td>
                                <td :class="'text-xs-center' + (!props.item.expired ? ' not-expired' : '')">{{ props.item.until !== null ? localizeDatetime(props.item.until) : $t('common.forever') }}</td>
                                <td :class="'text-xs-center' + (!props.item.expired ? ' not-expired' : '')">{{ props.item.reason }}</td>
                                <td class="justify-center layout px-0">
                                    <v-btn icon class="mx-0" @click="deleteItem(props.item)">
                                        <v-icon color="pink">delete</v-icon>
                                    </v-btn>
                                </td>
                            </template>
                        </v-data-table>
                        <v-layout>
                            <v-flex xs12 class="text-xs-right caption">
                                <div class="not-expired-caption"></div>
                                - {{ $t('content.admin.users.edit.actions.bans_history.caption') }}
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="secondary" flat @click.native="dialogData = false">{{ $t('common.close') }}</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-layout>
</template>

<script>
    import datetime from './../../../core/common/datetime'

    export default {
        props: {
            dialog: {
                required: true,
                type: Boolean
            },
            username: {
                required: true,
                type: String
            },
            bans: {
                required: true,
                type: Array
            }
        },
        data() {
            return {
                dialogData: this.dialog,
                items: this.bans,
                headers: [
                    {
                        text: $t('content.admin.users.edit.actions.bans_history.created_at'),
                        align: 'center',
                        sortable: true,
                        value: 'createdAt'
                    },
                    {
                        text: $t('content.admin.users.edit.actions.bans_history.until'),
                        align: 'center',
                        sortable: true,
                        value: 'until'
                    },
                    {
                        text: $t('content.admin.users.edit.actions.bans_history.reason'),
                        align: 'center',
                        sortable: true,
                        value: 'reason'
                    },
                    {
                        text: $t('common.actions'),
                        sortable: false
                    }
                ]
            }
        },
        watch: {
            dialog(val) {
                this.dialogData = val;
            },
            dialogData(val) {
                if (!val) {
                    this.$emit('close', this.models);
                }
            },
            bans(val) {
                this.items = val;
            }
        },
        methods: {
            localizeDatetime(val) {
                return datetime.localize(val);
            },
            deleteItem(ban) {
                if (confirm($t('content.admin.users.edit.actions.bans_history.delete'))) {
                    this.$axios.post(`/api/admin/users/edit/ban/${ban.id}`, {
                        _method: 'DELETE'
                    })
                        .then(response => {
                            if (response.data.status === 'success') {
                                this.items.forEach((each, index) => {
                                    if (each.id === ban.id) {
                                        this.items.splice(index, 1);
                                    }
                                });

                                this.$emit('update', this.items);
                                if (this.items.length === 0) {
                                    this.dialogData = false;
                                }
                            }
                        })
                }
            }
        }
    }
</script>

<style lang="sass" scoped>
    $red: #ff5252
    .not-expired
        color: $red
    .not-expired-caption
        display: inline-block
        width: 10px
        height: 10px
        background-color: $red
</style>
