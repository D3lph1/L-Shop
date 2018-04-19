<template>
    <v-layout row justify-center>
        <v-dialog v-model="dialogData" max-width="600px">
            <v-card>
                <v-card-title>
                    <span class="headline">{{ $t('content.frontend.profile.purchases.details.title') }}</span>
                </v-card-title>
                <v-card-text>
                    <v-data-table
                            :headers="headers"
                            :items="items"
                            hide-actions
                    >
                        <template slot="items" slot-scope="props">
                            <td class="text-xs-center"><img :src="props.item.image" height="30"></td>
                            <td class="text-xs-center">{{ props.item.name }} <v-enchanted class="cp" v-if="props.item.enchanted"></v-enchanted></td>
                            <td class="text-xs-center">{{ props.item.stack }}</td>
                            <td class="text-xs-center">{{ props.item.amount }}</td>
                            <td class="text-xs-center">{{ props.item.cost }} <span v-html="$store.state.shop.currency.html"></span></td>
                        </template>
                    </v-data-table>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="secondary" flat @click.native="dialogData = false">{{ $t('common.cancel') }}</v-btn>
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
            items: {
                required: true,
                type: Array
            }
        },
        data() {
            return {
                dialogData: this.dialog,
                headers: [
                    {
                        text: $t('content.frontend.profile.purchases.details.table.headers.image'),
                        align: 'center',
                        sortable: false,
                        value: 'image'
                    },
                    {
                        text: $t('content.frontend.profile.purchases.details.table.headers.name'),
                        align: 'center',
                        sortable: true,
                        value: 'name'
                    },
                    {
                        text: $t('content.frontend.profile.purchases.details.table.headers.stack'),
                        align: 'center',
                        sortable: true,
                        value: 'stack'
                    },
                    {
                        text: $t('content.frontend.profile.purchases.details.table.headers.amount'),
                        align: 'center',
                        sortable: true,
                        value: 'amount'
                    },
                    {
                        text: $t('content.frontend.profile.purchases.details.table.headers.cost'),
                        align: 'center',
                        sortable: true,
                        value: 'cost'
                    }
                ]
            }
        },
        watch: {
            dialog(val) {
                this.dialogData = val;
            },
            dialogData(val) {
                if (val === false) {
                    this.$emit('close', this.models);
                }
            }
        }
    }
</script>