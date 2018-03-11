<template>
    <v-flex xs12>
        <v-card color="secondary" class="white--text">
            <v-card-title primary-title>
                <div class="headline">{{ title }}</div>
                <div>{{ content }}</div>
            </v-card-title>
            <v-card-actions>
                <v-btn flat dark :to="{name: 'frontend.news', params: {news: id}}">{{ $t('content.layout.news.read') }}</v-btn>
            </v-card-actions>
        </v-card>
    </v-flex>
</template>

<script>
    export default {
        props: {
            id: {
                required: true,
                type: Number
            },
            title: {
                required: true,
                type: String
            },
            content: {
                required: true,
                type: String
            },
        }
    }
</script>
