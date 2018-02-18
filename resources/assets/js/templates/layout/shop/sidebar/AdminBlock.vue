<template>
    <v-list class="pt-0" dense>
        <v-subheader inset>{{ $t('content.layout.shop.sidebar.admin.title') }}</v-subheader>
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
            <v-list-tile v-for="(subItem, index) in item.subItems" :key="index" :href="subItem.link" target="_blank">
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
        }
    }
</script>