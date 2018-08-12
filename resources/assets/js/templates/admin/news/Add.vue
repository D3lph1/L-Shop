<template>
    <v-layout align-center justify-center>
        <v-flex xs12 sm12 md10 lg8>
            <v-card>
                <v-card-title class="text-xs-center">
                    <h3>{{ $t('content.admin.news.add.title') }}</h3>
                    <v-spacer></v-spacer>
                    <span class="caption" v-html="$t('common.unclear_docs', {link: 'https://github.com/D3lph1/L-shop/wiki'})"></span>
                </v-card-title>
                <v-card-text>
                    <v-text-field
                            v-model="title"
                            prepend-icon="text_format"
                            :label="$t('content.admin.news.add.title_input')"
                    ></v-text-field>
                    <quill-editor
                            v-model="content"
                    >
                    </quill-editor>
                </v-card-text>
                <v-card-actions>
                    <v-btn flat color="orange" :disabled="finishDisabled" :loading="finishLoading" @click="perform">{{ $t('content.admin.news.add.finish') }}</v-btn>
                </v-card-actions>
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
    import loader from './../../../core/http/loader'

    export default {
        data() {
            return {
                title: '',
                content: $t('content.admin.news.add.content'),
                finishLoading: false
            }
        },
        beforeRouteEnter (to, from, next) {
            loader.beforeRouteEnter('/spa/admin/news/add', to, from, next);
        },
        beforeRouteUpdate (to, from, next) {
            loader.beforeRouteUpdate('/spa/admin/news/add', to, from, next, this);
        },
        computed: {
            finishDisabled() {
                return this.title === '' || this.content === '';
            }
        },
        methods: {
            perform() {
                this.finishLoading = true;

                this.$axios.post('/spa/admin/news/add', {
                    title: this.title,
                    content: this.content
                })
                    .then(response => {
                        if (response.data.status === 'success') {
                            this.$router.push({name: 'admin.news.list'});
                        } else {
                            this.finishLoading = false;
                        }
                    });
            },
            setData(response) {
                //
            }
        },
        components: {
            quillEditor: () => import(/* webpackChunkName: "tools/editor" */ 'vue-quill-editor').then(({ quillEditor }) => quillEditor)
        }
    }
</script>

<style lang="less">
    div.ql-editor {
        height: 500px;
    }
</style>
