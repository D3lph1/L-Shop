<template>
    <div>
        <div id="logo-block">
            <div class="logo-img">
                <img :src="logo" alt="logo" class="c-logo">
            </div>
            <div class="logo-text">
                <h1 class="display-3 grey--text text--darken-3">L-Shop</h1>
            </div>
        </div>
    </div>
</template>

<script>
    import loader from './../../../core/http/loader'

    export default {
        data() {
            return {
                logo: null
            }
        },
        beforeRouteEnter (to, from, next) {
            loader.beforeRouteEnter('/api/admin/information/about', to, from, next);
        },
        beforeRouteUpdate (to, from, next) {
            loader.beforeRouteUpdate('/api/admin/information/about', to, from, next, this);
        },
        methods: {
            setData(response) {
                const data = response.data;

                this.logo = data.logo;
            }
        }
    }
</script>
