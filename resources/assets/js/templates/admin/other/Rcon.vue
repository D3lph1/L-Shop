<template>
    <!-- Make something amazing... -->
</template>

<script>
    import loader from './../../../core/http/loader'

    export default {
        data() {
            return {
                //
            }
        },
        beforeRouteEnter (to, from, next) {
            loader.beforeRouteEnter('/spa/admin/other/rcon', to, from, next);
        },
        beforeRouteUpdate (to, from, next) {
            loader.beforeRouteUpdate('/spa/admin/other/rcon', to, from, next, this);
        },
        methods: {
            setData(response) {
                const data = response.data;
            }
        }
    }
</script>
