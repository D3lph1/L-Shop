<template>
    <div id="news-content" class="z-depth-1">
        <button id="news-back" class="btn"><i class="fa fa-arrow-right"></i></button>
        <div id="news-block">
            <div v-if="empty" class="alert alert-info text-center">
                {{ $t('content.shop.news.empty') }}
            </div>

            <div v-for="one in news" class="news-preview z-depth-1">
                <h3 class="news-pre-header">{{ one.title }}</h3>
                <p class="news-pre-text">{{ one.content }}</p>
                <a :href="one.link" class="btn btn-info btn-sm btn-block mt-1">{{ $t('content.shop.news.read_more') }}</a>
            </div>
        </div>
        <button v-if="allowLoadMore" id="news-load-more" class="btn btn-blue-grey btn-block mt-1" @click="loadMore($event.target)"><i class="fa fa-plus"></i></button>
    </div>
</template>

<script>
    export default {
        props: ['empty', 'news', 'allowLoadMore', 'loadMoreUrl'],
        methods: {
            loadMore(target) {
                const count = document.querySelectorAll('#news-block>div').length;
                axios.post(this.loadMoreUrl, {
                    count: count
                }).then((response) => {
                    response = response.data;

                    if (response.status === 'news_disabled') {
                        msg.call(response.message.type, response.message.text);

                        return;
                    }

                    if (response.status === 'no_more_news') {
                        msg.call(response.message.type, response.message.text);
                        target.style.display = 'none';

                        return;
                    }

                    if (response.status === 'last_portion') {
                        target.style.display = 'none';
                    }

                    let content = response.news;
                    let result = '';

                    for (let i = 0; i < content.length; i++) {
                        result += '<div class="news-preview z-depth-1"><h3 class="news-pre-header">' + content[i].title + '</h3><p class="news-pre-text">' + content[i].content + '</p> <a href="' + content[i].link + '" class="btn btn-info btn-sm btn-block mt-1">' + response.more + '</a> </div>';
                    }

                    const element = document.getElementById('news-block');
                    element.innerHTML = element.innerHTML + result;
                });
            }
        }
    }
</script>