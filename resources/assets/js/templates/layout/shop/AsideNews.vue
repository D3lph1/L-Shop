<template>
    <div>
        <v-toolbar flat>
            <v-toolbar-title id="drawer-header">
                <v-icon>library_books</v-icon><span>{{ $t('content.layout.news.title') }}</span>
            </v-toolbar-title>
        </v-toolbar>
        <v-divider></v-divider>
        <div id="drawer-news-block">
            <div class="news-card" v-for="item in items.news">
                <h1 class="news-header">{{ item.title }}</h1>
                <p class="news-content">{{ item.content }}</p>
                <p class="date-block">{{ datetime.localize(item.createdAt) }}</p>
                <v-divider></v-divider>
                <v-btn class="fade-hover" :to="{name: 'frontend.news', params: {news: item.id}}">
                    {{ $t('content.layout.news.read') }}
                    <v-icon x-large>keyboard_arrow_right</v-icon>
                </v-btn>
            </div>
            <div class="more-block" v-if="items.total > items.news.length">
                <v-btn flat outline large color="primary" @click="loadMore" :loading="loading">{{ $t('content.layout.news.load') }}</v-btn>
            </div>
        </div>
    </div>
</template>

<script>
    import DateTime from '../../../core/common/datetime'

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
                loading: false,
                datetime: DateTime
            }
        },
        methods: {
            loadMore() {
                this.loading = true;
                this.$axios.get('/spa/news/load', {
                    params: {
                        portion: ++this.items.portion
                    }
                }).then((response) => {
                    if (response.data.status === 'success') {
                        response.data.items.news.forEach(item => {
                            this.items.news.push(item);
                        });

                        this.loading = false;
                    }
                });
            }
        }
    }
</script>

<style lang="less">
    #drawer-header {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        margin: 0;
        span {
            margin-left: 10px;
        }
    }

    #drawer-news-block {
        .news-card {
            position: relative;
            padding: 5px 10px 0 10px;
            .news-content {
                margin-bottom: 0;
            }
            .date-block {
                text-align: right;
                margin-bottom: 5px;
            }
            .fade-hover {
                position: absolute;
                top: 0;
                left: 0;
                margin: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                background-color: rgba(51,51,51, .8);
                width: 100%;
                height: 100%;
                opacity: 0;
                transition: opacity .3s;
                box-shadow: none;
                border-radius: 0;
                color: #fff;
                font-size: 30px;
                &:hover {
                    opacity: 1;
                }
            }
        }
        .more-block {
            width: 100%;
            padding: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    }
</style>
