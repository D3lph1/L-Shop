<template>
    <v-flex xs12>
        <v-card color="secondary" class="white--text">
            <v-card-title primary-title>
                <div class="headline">{{ item.title }}</div>
                <div>{{ item.content }}</div>
            </v-card-title>
            <v-card-actions>
                <v-btn flat dark>{{ $t('content.layout.news.read') }}</v-btn>
            </v-card-actions>
        </v-card>
    </v-flex>
</template>

<script>
    export default {
        props: {
            item: {
                required: true,
                type: Object
            }
        }
    }
</script>
