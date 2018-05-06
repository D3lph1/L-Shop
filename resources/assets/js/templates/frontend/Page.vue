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
            loader.beforeRouteEnter(`/spa/page/${to.params.url}`, to, from, next);
        },
        beforeRouteUpdate (to, from, next) {
            loader.beforeRouteUpdate(`/spa/page/${to.params.url}`, to, from, next, this);
        },
        methods: {
            setData(response) {
                const data = response.data;

                this.content = data.content;
                document.title = data.title + ' | ' + document.title;
            }
        }
    }
</script>
