<template>
    <v-layout row wrap>
        <v-flex xs12 md5>
            <permissions-table></permissions-table>
        </v-flex>
        <v-flex xs12 md7>
            <roles-table></roles-table>
        </v-flex>
    </v-layout>
</template>

<script>
    import RolesTable from './RolesTable.vue'
    import PermissionsTable from './PermissionsTable.vue'

    export default {
        components: {
            'roles-table': RolesTable,
            'permissions-table': PermissionsTable
        }
    }
</script>
