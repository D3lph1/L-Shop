<template>
    <div id="news-content" class="z-depth-1">
        <button id="news-back" class="btn"><i class="fa fa-arrow-right"></i></button>
        <div id="news-block">
            <div v-if="i.total === 0" class="alert alert-info text-center">
                {{ $t('content.shop.news.empty') }}
            </div>

            <news-item v-for="each in i.news" :key="each.id" :news="each" class="news-preview z-depth-1"></news-item>
        </div>
        <button v-if="i.total > i.news.length" id="news-load-more" class="btn btn-blue-grey btn-block mt-1" @click="loadMore"><i class="fa fa-plus"></i></button>
    </div>
</template>

<script>
    import Item from './Item.vue'

    export default {
        props: ['items', 'routeLoadMore'],
        data() {
            return {
                i: this.items
            }
        },
        methods: {
            loadMore() {
                axios.post(this.routeLoadMore, {
                    portion: ++this.i.portion
                }).then((response) => {
                    if (response.data.status === 'success') {
                        for (let each in response.data.items.news) {
                            this.i.news.push(response.data.items.news[each]);
                        }
                    }
                });
            }
        },
        components: {
            'news-item': Item
        }
    }
</script>