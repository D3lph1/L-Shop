<template>
    <v-list class="pt-0" dense v-if="$store.getters.isAuth">
        <v-subheader inset>{{ $t('content.layout.shop.sidebar.profile.title') }}</v-subheader>
        <div v-for="item in items" v-if="(typeof item.visible === 'undefined') || item.visible">
            <v-list-tile v-if="typeof item.subItems === 'undefined' || item.subItems.length === 0" :to="item.to">
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
                <v-list-tile v-for="(subItem, index) in item.subItems" :key="index" :to="subItem.to">
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
        computed: {
            items() {
                return [
                    {
                        icon: 'accessibility',
                        title: $t('content.layout.shop.sidebar.profile.character'),
                        to: {name: 'frontend.profile.character'},
                        visible: this.character
                    },
                    {
                        icon: 'build',
                        title: $t('content.layout.shop.sidebar.profile.settings'),
                        to: {name: 'frontend.profile.settings'}
                    },
                    {
                        icon: 'info_outline',
                        title: $t('content.layout.shop.sidebar.profile.information.title'),
                        subItems: [
                            {
                                title: $t('content.layout.shop.sidebar.profile.information.sub_items.purchases'),
                                to: {name: 'frontend.profile.purchases'}
                            },
                            {
                                title: $t('content.layout.shop.sidebar.profile.information.sub_items.cart'),
                                to: {name: 'frontend.profile.cart'}
                            }
                        ]
                    }
                ];
            }
        }
    }
</script>
