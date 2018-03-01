<template>
    <v-layout row wrap>
        <v-flex xs12 sm12 md6 lg4>

        </v-flex>
    </v-layout>
</template>

<script>
    import loader from './../../../core/http/loader'

    export default {
        beforeRouteEnter (to, from, next) {
            loader.beforeRouteEnter('/api/admin/statistic/show', to, from, next);
        },
        beforeRouteUpdate (to, from, next) {
            loader.beforeRouteUpdate('/api/admin/statistic/show', to, from, next, this);
        },
        methods: {
            setData(response) {
                const data = response.data;
            }
        },
        components: {
            //
        }
    }
</script>
