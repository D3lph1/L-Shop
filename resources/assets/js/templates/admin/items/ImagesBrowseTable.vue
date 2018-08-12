<template>
    <v-radio-group v-model="selected">
        <v-data-table
                :headers="headers"
                :items="images"
                item-key="name"
                :rows-per-page-items="[5]"
                @update:pagination="updatePagination"
        >
            <template slot="pageText" slot-scope="{ pageStart, pageStop }">
                {{ pageStart }} - {{ pageStop }} {{ $t('common.table.of') }} {{ images.length }}
            </template>
            <template slot="items" slot-scope="props">
                <td class="text-xs-right">
                    <v-radio
                            color="secondary"
                            :value="props.item"
                    ></v-radio>
                </td>
                <td class="text-xs-right">{{ props.item.name }}</td>
                <td class="text-xs-right"><img height="35" :src="props.item.url"></td>
            </template>
        </v-data-table>
    </v-radio-group>
</template>

<script>
    export default {
        props: {
            images: {
                required: true,
                type: Array
            },
            active: {
                required: false,
                default: null
            }
        },
        data () {
            return {
                selected: null,
                headers: [
                    {
                        text: $t('content.admin.items.add.browser.select'),
                        align: 'left',
                        sortable: false
                    },
                    {
                        text: $t('content.admin.items.add.browser.name'),
                        align: 'right',
                        sortable: true,
                        value: 'name'
                    },
                    {
                        text: $t('common.image'),
                        align: 'right',
                        sortable: false
                    },
                ],
            }
        },
        watch: {
            active(val) {
                if (this.selected === null) {
                    this.selected = val;
                }
            },
            selected(val) {
                this.$emit('select', val);
            }
        },
        methods: {
            updatePagination() {
                this.selected = null;
            }
        }
    }
</script>
