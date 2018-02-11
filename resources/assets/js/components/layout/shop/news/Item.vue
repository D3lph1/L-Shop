<template>
    <div>
        <h3 class="news-pre-header">{{ news.title }}</h3>
        <p class="news-pre-text">{{ news.content }}</p>
        <a :href="news.url" class="btn btn-info btn-sm btn-block mt-1">{{ $t('content.shop.news.read_more') }}</a>
    </div>
</template>

<script>
    export default {
        props: ['news']
    }
</script>
