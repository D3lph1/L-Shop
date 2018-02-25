<template>
    <div>

    </div>
</template>

<script>
    import loader from './../../../core/http/loader'

    export default {
        beforeRouteEnter (to, from, next) {
            loader.beforeRouteEnter('/api/admin/control/basic', to, from, next);
        },
        beforeRouteUpdate (to, from, next) {
            loader.beforeRouteUpdate('/api/admin/control/basic', to, from, next, this);
        },
        methods: {
            setData(response) {
                const data = response.data;
            }
        }
    }
</script>
