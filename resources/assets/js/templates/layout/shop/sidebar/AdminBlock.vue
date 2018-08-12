<template>
    <v-list class="pt-0 pb-0" subheader v-if="$store.getters.isAuth">
        <v-subheader>{{ $t('content.layout.shop.sidebar.admin.title') }}</v-subheader>
        <v-list-group
                v-for="item in items"
                :key="item.title"
                :prepend-icon="item.icon"
                no-action
        >
            <v-list-tile slot="activator">
                <v-list-tile-content>
                    <v-list-tile-title>{{ item.title }}</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>
            <v-list-tile
                    v-for="(subItem, index) in item.subItems"
                    :key="index"
                    :to="to(subItem) ? to(subItem) : null"
                    :href="href(subItem) ? href(subItem) : null"
                    :target="href(subItem) && subItem.target ? subItem.target : null"
            >
                <v-list-tile-content>
                    <v-list-tile-title>{{ subItem.title }}</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>
        </v-list-group>
    </v-list>
</template>

<script>
    export default {
        props: {
            items: {
                required: true,
                type: Array
            }
        },
        methods: {
            href(subItem) {
                if (subItem.absolute) {
                    return subItem.link;
                }

                return false;
            },
            to(subItem) {
                if (subItem.absolute) {
                    return false;
                }

                return {name: subItem.link};
            }
        }
    }
</script>