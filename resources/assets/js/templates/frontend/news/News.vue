<template>
    <v-container>
        <v-card>
            <v-card-title primary-title>
                <h2 v-html="title"></h2>
            </v-card-title>
            <v-card-text v-html="content"></v-card-text>
            <v-card-actions>
                <v-container>
                    <v-layout>
                        <v-flex xs12 sm6>
                            <v-icon>person</v-icon> <span class="ml-2">{{ user }}</span>
                        </v-flex>
                        <v-flex xs12 sm6 class="text-xs-right">
                            <v-icon>date_range</v-icon> <span class="ml-2">{{ publishedAt }}</span>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card-actions>
        </v-card>
    </v-container>
</template>

<script>
    import loader from '../../../core/http/loader'
    import DateTime from '../../../core/common/datetime'

    export default {
        data() {
            return {
                title: null,
                content: null,
                user: null,
                publishedAt: null
            }
        },
        beforeRouteEnter (to, from, next) {
            loader.beforeRouteEnter(`/spa/news/${to.params.news}`, to, from, next);
        },
        beforeRouteUpdate (to, from, next) {
            loader.beforeRouteUpdate(`/spa/news/${to.params.news}`, to, from, next, this);
        },
        methods: {
            setData(response) {
                const data = response.data;

                document.title = data.news.title + ' | ' + document.title;
                this.title = data.news.title;
                this.content = data.news.content;
                this.user = data.news.user;
                this.publishedAt = DateTime.localize(data.news.publishedAt);
            }
        }
    }
</script>