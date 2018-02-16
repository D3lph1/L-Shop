<template>
    <v-list class="pt-0" dense>
        <v-subheader inset>{{ $t('content.layout.shop.sidebar.profile.title') }}</v-subheader>
        <div v-for="item in items">
            <v-list-tile v-if="typeof item.subItems === 'undefined' || item.subItems.length === 0" @click="">
                <v-list-tile-action>
                    <v-icon>{{ item.icon }}</v-icon>
                </v-list-tile-action>
                <v-list-tile-content>
                    <v-list-tile-title>{{ item.title }}</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>


            <v-list-group
                    v-else
                    :key="item.title"
                    :prepend-icon="item.icon"
                    no-action
            >
                <v-list-tile slot="activator">
                    <v-list-tile-content>
                        <v-list-tile-title>{{ item.title }}</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
                <v-list-tile v-for="(subItem, index) in item.subItems" :key="index" @click="">
                    <v-list-tile-content>
                        <v-list-tile-title>{{ subItem.title }}</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
            </v-list-group>
        </div>
    </v-list>
</template>

<script>
    export default {
        props: {
            character: {
                required: true,
                type: Boolean
            }
        },
        data() {
            return {
                items: [
                    {
                        icon: 'accessibility',
                        title: $t('content.layout.shop.sidebar.profile.character')
                    },
                    {
                        icon: 'settings',
                        title: $t('content.layout.shop.sidebar.profile.settings')
                    },
                    {
                        icon: 'info_outline',
                        title: $t('content.layout.shop.sidebar.profile.information.title'),
                        subItems: [
                            {
                                title: $t('content.layout.shop.sidebar.profile.information.sub_items.payments')
                            },
                            {
                                title: $t('content.layout.shop.sidebar.profile.information.sub_items.cart')
                            }
                        ]
                    }
                ]
            }
        }
    }
</script>
