<template>
    <v-layout row justify-center>
        <v-dialog persistent v-model="dialogData" max-width="400px">
            <v-card>
                <v-card-title>
                    <span class="headline">
                        <span v-if="firstBan">{{ $t('content.admin.users.edit.actions.show_ban_dialog') }}</span>
                        <span v-else>{{ $t('content.admin.users.edit.actions.show_add_ban_dialog') }}</span>
                    </span>
                </v-card-title>
                <v-card-text>
                    <v-container grid-list-md>
                        <v-layout row wrap>
                            <v-flex xs12>
                                <v-checkbox
                                        :label="$t('content.admin.users.edit.actions.add_ban.forever')"
                                        color="secondary"
                                        v-model="forever"
                                ></v-checkbox>
                            </v-flex>
                            <v-flex xs12 class="text-xs-center">
                                <p>{{ $t('content.admin.users.edit.actions.add_ban.duration') }}</p>
                                <v-btn-toggle mandatory v-model="mode">
                                    <v-btn flat value="concrete" :disabled="forever">
                                        {{ $t('content.admin.users.edit.actions.add_ban.concrete') }}
                                    </v-btn>
                                    <v-btn flat value="days" :disabled="forever">
                                        {{ $t('content.admin.users.edit.actions.add_ban.in_days') }}
                                    </v-btn>
                                </v-btn-toggle>
                            </v-flex>
                            <v-flex xs12 v-show="mode === 'concrete'">
                                <v-menu
                                        ref="dateMenu"
                                        lazy
                                        :close-on-content-click="false"
                                        v-model="dateMenu"
                                        :disabled="forever"
                                        transition="scale-transition"
                                        offset-y
                                        full-width
                                        :nudge-right="40"
                                        max-width="290px"
                                        min-width="290px"
                                        :return-value.sync="date"
                                >
                                    <v-text-field
                                            slot="activator"
                                            :label="$t('content.admin.users.edit.actions.add_ban.date')"
                                            v-model="date"
                                            prepend-icon="event"
                                            readonly
                                    ></v-text-field>
                                    <v-date-picker
                                            v-model="date"
                                            no-title
                                            scrollable
                                            :min="new Date().toISOString().substr(0, 10)"
                                    >
                                        <v-spacer></v-spacer>
                                        <v-btn flat color="primary" @click="dateMenu = false">Cancel</v-btn>
                                        <v-btn flat color="primary" @click="$refs.dateMenu.save(date)">OK</v-btn>
                                    </v-date-picker>
                                </v-menu>
                                <v-menu
                                        ref="timeMenu"
                                        lazy
                                        :close-on-content-click="false"
                                        v-model="timeMenu"
                                        :disabled="forever"
                                        transition="scale-transition"
                                        offset-y
                                        full-width
                                        :nudge-right="40"
                                        max-width="290px"
                                        min-width="290px"
                                        :return-value.sync="time"
                                >
                                    <v-text-field
                                            slot="activator"
                                            :label="$t('content.admin.users.edit.actions.add_ban.time')"
                                            v-model="time"
                                            prepend-icon="access_time"
                                            readonly
                                    ></v-text-field>
                                    <v-time-picker
                                            v-model="time"
                                            format="24hr"
                                            :min="minTime()"
                                            @change="$refs.timeMenu.save(time)"
                                    ></v-time-picker>
                                </v-menu>
                            </v-flex>
                            <v-flex xs12 v-show="mode === 'days'">
                                <v-text-field
                                        type="number"
                                        class="no-spinners"
                                        v-model="days"
                                        :label="$t('content.admin.users.edit.actions.add_ban.days')"
                                        :disabled="forever"
                                ></v-text-field>
                            </v-flex>
                            <v-flex xs12>
                                <v-text-field
                                        :label="$t('content.admin.users.edit.actions.add_ban.reason')"
                                        v-model="reason"
                                ></v-text-field>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" flat :loading="finishLoading" :disabled="finishDisabled" @click.native="finish">{{ $t('content.admin.users.edit.actions.add_ban.finish') }}</v-btn>
                    <v-btn color="primary" flat @click.native="dialogData = false">{{ $t('common.close') }}</v-btn>
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
            firstBan: {
                required: true,
                type: Boolean
            },
            userId: {
                required: true,
                type: Number
            }
        },
        data() {
            return {
                dialogData: this.dialog,
                forever: false,
                mode: 'concrete',
                date: null,
                time: null,
                dateMenu: false,
                timeMenu: false,
                days: 1,
                reason: null,
                finishLoading: false
            }
        },
        computed: {
            finishDisabled() {
                if (this.forever) {
                    return false;
                }

                if (this.mode === 'concrete') {
                    return this.date === null || this.date === '' ||
                            this.time === null || this.date === '';
                } else if (this.mode === 'days') {
                    return this.days === null || this.days === '' || this.days <= 0 ||
                        Number(this.days) !== parseInt(Number(this.days), 10)
                }
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
            }
        },
        methods: {
            minTime() {
                if (!this.date || (this.date && new Date(this.date).getDay() === new Date().getDay())) {
                    return (new Date().getHours() < 10 ? '0' : '') + new Date().getHours() + ':' + (new Date().getMinutes() < 10 ? '0' : '') + new Date().getMinutes();
                }

                return '00:00';
            },
            finish() {
                this.finishLoading = true;
                this.$axios.post(`/spa/admin/users/edit/${this.userId}/ban`, {
                    forever: this.forever,
                    mode: this.mode,
                    date_time: !this.forever ? new Date(`${this.date} ${this.time}`) : null,
                    days: this.days,
                    time: this.time,
                    reason: this.reason
                })
                    .then(response => {
                        this.finishLoading = false
                        if (response.data.status === 'success') {
                            this.$emit('add', response.data.ban);
                            this.dialogData = false;
                        }
                    });
            }
        }
    }
</script>
