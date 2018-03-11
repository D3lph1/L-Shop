<template>
    <v-container>
        <v-card>
            <v-card-text v-html="content"></v-card-text>
        </v-card>
    </v-container>
</template>

<script>
    import loader from '../../core/http/loader'

    export default {
        data() {
            return {
                content: null
            }
        },
        beforeRouteEnter (to, from, next) {
            loader.beforeRouteEnter(`/api/page/${to.params.url}`, to, from, next);
        },
        beforeRouteUpdate (to, from, next) {
            loader.beforeRouteUpdate(`/api/page/${to.params.url}`, to, from, next, this);
        },
        methods: {
            setData(response) {
                const data = response.data;

                this.content = data.page.content;
                document.title = data.page.title + ' | ' + document.title;
            }
        }
    }
</script>
