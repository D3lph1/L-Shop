<template>
    <v-container
            fluid
            style="min-height: 0;"
            grid-list-lg
    >
        <v-layout row wrap v-if="items.total > 0">
            <news-item
                    v-for="(each, index) in items.news"
                    :key="index"
                    :id="each.id"
                    :title="each.title"
                    :content="each.content"
            ></news-item>
        </v-layout>
        <v-layout row wrap v-else>
            <v-flex xs12>
                <v-alert type="info" :value="true">
                    <div class="text-xs-center">{{ $t('content.layout.news.empty') }}</div>
                </v-alert>
            </v-flex>
        </v-layout>
        <v-bottom-nav v-if="items.total > items.news.length">
            <v-btn flat color="primary" @click="loadMore" :loading="loading">
                <span>{{ $t('content.layout.news.load') }}</span>
                <v-icon>more_horiz</v-icon>
            </v-btn>
        </v-bottom-nav>
    </v-container>
</template>

<script>
    import Item from './Item.vue'

    export default {
        props: {
            news: {
                required: true,
                type: Object
            }
        },
        data() {
            return {
                items: this.news,
                loading: false
            }
        },
        methods: {
            loadMore() {
                this.loading = true;
                this.$axios.get('/api/news/load', {
                    params: {
                        portion: ++this.items.portion
                    }
                }).then((response) => {
                    if (response.data.status === 'success') {
                        for (let each in response.data.items.news) {
                            if (response.data.items.news.hasOwnProperty(each)) {
                                this.items.news.push(response.data.items.news[each]);
                            }
                        }

                        this.loading = false;
                    }
                });
            }
        },
        components: {
            'news-item': Item
        },
    }
</script>

<style lang="sass" scoped>
    .bottom-nav
        box-shadow: none
</style>
