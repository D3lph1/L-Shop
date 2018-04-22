<template>
    <v-layout align-center justify-center>
        <v-flex xs12 sm12 md10 lg8>
            <v-card>
                <v-card-title class="text-xs-center">
                    <h3>{{ $t('content.admin.pages.edit.title') }}</h3>
                    <v-spacer></v-spacer>
                    <span class="caption" v-html="$t('common.unclear_docs', {link: 'https://github.com/D3lph1/L-shop/wiki'})"></span>
                </v-card-title>
                <v-card-text>
                    <v-text-field
                            v-model="title"
                            prepend-icon="text_format"
                            :label="$t('content.admin.pages.add.title_input')"
                    ></v-text-field>
                    <v-text-field
                            multi-line
                            v-model="content"
                            prepend-icon="view_headline"
                            :label="$t('content.admin.pages.add.content')"
                    ></v-text-field>
                    <v-text-field
                            v-model="url"
                            prepend-icon="link"
                            :label="$t('content.admin.pages.add.url')"
                            :disabled="autoUrl"
                    ></v-text-field>
                    <v-switch
                            v-model="autoUrl"
                            color="secondary"
                            :label="$t('content.admin.pages.add.url_auto')"
                    ></v-switch>
                </v-card-text>
                <v-card-actions>
                    <v-btn flat color="orange" :disabled="finishDisabled" :loading="finishLoading" @click="perform">{{ $t('content.admin.pages.add.finish') }}</v-btn>
                </v-card-actions>
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
    import loader from './../../../core/http/loader'
    import Transliterator from './../../../core/common/transliterator'

    export default {
        data() {
            return {
                title: null,
                content: null,
                autoUrl: false,
                url: null,
                finishLoading: false
            }
        },
        beforeRouteEnter (to, from, next) {
            loader.beforeRouteEnter(`/spa/admin/pages/edit/${to.params.page}`, to, from, next);
        },
        beforeRouteUpdate (to, from, next) {
            loader.beforeRouteUpdate(`/spa/admin/pages/edit/${to.params.page}`, to, from, next, this);
        },
        watch: {
            title(val) {
                if (this.autoUrl) {
                    this.url = this.transliterate(val);
                }
            },
            autoUrl(val) {
                if (val) {
                    this.url = this.transliterate(this.title);
                }
            }
        },
        computed: {
            finishDisabled() {
                return this.title === null || this.title === '' ||
                    this.content === null || this.content === '' ||
                    this.url === null || this.url === '';
            }
        },
        methods: {
            transliterate(text) {
                return Transliterator.rusToEng(Transliterator.slaggade(text));
            },
            perform() {
                this.finishLoading = true;
                this.$axios.post(`/spa/admin/pages/edit/${this.$route.params.page}`, {
                    title: this.title,
                    content: this.content,
                    url: this.url
                })
                    .then(response => {
                        if (response.data.status === 'success') {
                            this.$router.push({name: 'admin.pages.list'});
                        } else {
                            this.finishLoading = false;
                        }
                    });
            },
            setData(response) {
                const data = response.data;

                this.title = data.page.title;
                this.content = data.page.content;
                this.url = data.page.url;
            }
        }
    }
</script>
