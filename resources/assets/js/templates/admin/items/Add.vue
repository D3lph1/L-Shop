<template>
    <v-layout align-center justify-center>
        <v-flex xs12 sm12 md10 lg8>
            <v-card>
                <v-card-title class="text-xs-center">
                    <h3>{{ $t('content.admin.items.add.title') }}</h3>
                    <v-spacer></v-spacer>
                    <span class="caption" v-html="$t('common.unclear_docs', {link: 'https://github.com/D3lph1/L-shop/wiki'})"></span>
                </v-card-title>
                <v-card-text>
                    <v-text-field
                            :label="$t('content.admin.items.add.name')"
                            prepend-icon="title"
                            v-model="name"
                    ></v-text-field>
                    <v-text-field
                            :label="$t('content.admin.items.add.description')"
                            prepend-icon="mode_edit"
                            :multi-line="true"
                            v-model="description"
                    ></v-text-field>
                    <v-select
                            :items="types"
                            item-value="value"
                            v-model="type"
                            :label="$t('common.type')"
                            prepend-icon="check"
                    >
                        <template slot="item" slot-scope="data">
                            <v-list-tile-avatar>
                                <v-icon>{{ data.item.icon }}</v-icon>
                            </v-list-tile-avatar>
                            <v-list-tile-content>
                                <v-list-tile-title v-html="data.item.text"></v-list-tile-title>
                            </v-list-tile-content>
                        </template>
                    </v-select>

                    <div class="text-xs-center">
                        <p class="subheading">{{ $t('common.image') }}</p>
                        <v-btn-toggle mandatory v-model="imageType">
                            <v-btn small flat value="default">
                                {{ $t('content.admin.items.add.image.default') }}
                            </v-btn>
                            <v-btn small flat value="upload">
                                {{ $t('content.admin.items.add.image.upload') }}
                            </v-btn>
                            <v-btn small flat value="browse">
                                {{ $t('content.admin.items.add.image.browse') }}
                            </v-btn>
                        </v-btn-toggle>

                        <div class="add-image-block">
                            <div v-show="imageType === 'default'">
                                <img src="/img/shop/items/default.png" class="preview" alt="default">
                            </div>
                            <div v-show="imageType === 'upload'">
                                <img v-if="imagePreviewUpload" :src="imagePreviewUpload" class="preview" alt="uploaded">
                                <v-uploader
                                        accept="image/jpeg,image/png,image/gif"
                                        @preview="setImagePreview"
                                        @formData="setUploadedImage"
                                ></v-uploader>
                            </div>
                            <div v-show="imageType === 'browse'">
                                <img v-if="imagePreviewBrowser" :src="imagePreviewBrowser" class="preview" alt="uploaded">
                                <v-subheader inset>{{ $t('content.admin.items.add.browser.title') }}</v-subheader>
                                <images-browse-table :images="images" @select="setImagePreviewBrowser"></images-browse-table>
                            </div>
                        </div>
                    </div>

                    <v-text-field
                            :label="$t(`content.admin.items.add.${type}.id`)"
                            prepend-icon="fingerprint"
                            v-model="id"
                    ></v-text-field>
                    <v-text-field
                            :label="$t('content.admin.items.add.extra')"
                            prepend-icon="list"
                            v-model="extra"
                    ></v-text-field>
                </v-card-text>
                <v-card-actions>
                    <v-btn flat color="orange" :disabled="finishDisabled" @click="perform">{{ $t('content.admin.items.add.finish') }}</v-btn>
                </v-card-actions>
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
    import loader from './../../../core/http/loader'
    import Table from './ImagesBrowseTable.vue'

    export default {
        data() {
            return {
                name: null,
                description: null,
                type: 'item',
                types: [
                    {
                        text: $t('common.item.type.item'),
                        value: 'item',
                        icon: 'beach_access'
                    },
                    {
                        text: $t('common.item.type.permgroup'),
                        value: 'permgroup',
                        icon: 'turned_in_not'
                    }
                ],
                imageType: 'default',
                imagePreviewUpload: null,
                imagePreviewBrowser: null,
                imageBrowser: null,
                image: null,
                images: [],
                id: null,
                extra: null
            }
        },
        beforeRouteEnter (to, from, next) {
            loader.beforeRouteEnter('/api/admin/items/add', to, from, next);
        },
        beforeRouteUpdate (to, from, next) {
            loader.beforeRouteUpdate('/api/admin/items/add', to, from, next, this);
        },
        computed: {
            finishDisabled() {
                return this.name === null || this.name === '' ||
                    this.id === null || this.id === '';
            }
        },
        methods: {
            setImagePreview(preview) {
                if (preview[0]) {
                    this.imagePreviewUpload = preview;
                } else {
                    this.imagePreviewUpload = null;
                }
            },
            setImagePreviewBrowser(val) {
                if (val === null) {
                    this.imagePreviewBrowser = null;
                    this.imageBrowser = null;
                } else {
                    this.imagePreviewBrowser = val.url;
                    this.imageBrowser = val.name;
                }
            },
            setUploadedImage(form) {
                this.image = form;
            },
            perform() {
                const data = this.image !== null ? this.image : new FormData();
                data.append('name', this.name);
                data.append('description', this.description);
                data.append('item_type', this.type);
                data.append('image_type', this.imageType);
                data.append('image_name', this.imageBrowser);
                data.append('game_id', this.id);
                data.append('extra', this.extra);

                this.$axios.post('/api/admin/items/add', data)
                    .then((response) => {
                        if (response.data.status === 'success') {
                            this.$router.push({name: 'admin.items.list'});
                        }
                    });
            },
            setData(response) {
                const data = response.data;

                this.images = data.images;
            }
        },
        components: {
            'images-browse-table': Table
        }
    }
</script>
