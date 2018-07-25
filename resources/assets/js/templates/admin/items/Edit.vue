<template>
    <v-layout align-center justify-center>
        <v-flex xs12 sm12 md10 lg8>
            <v-card>
                <v-card-title class="text-xs-center">
                    <h3>{{ $t('content.admin.items.edit.title') }}</h3>
                    <v-spacer></v-spacer>
                    <span class="caption" v-html="$t('common.unclear_docs', {link: 'https://github.com/D3lph1/L-shop/wiki'})"></span>
                </v-card-title>
                <v-card-text>
                    <v-text-field
                            :label="$t('content.admin.items.add.name')"
                            prepend-icon="title"
                            v-model="item.name"
                    ></v-text-field>
                    <v-text-field
                            :label="$t('content.admin.items.add.description')"
                            prepend-icon="mode_edit"
                            :multi-line="true"
                            v-model="item.description"
                    ></v-text-field>
                    <v-select
                            :items="types"
                            item-value="value"
                            v-model="item.type"
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
                            <v-btn small flat value="current" v-show="item.image !== null">
                                {{ $t('content.admin.items.edit.image.current') }}
                            </v-btn>
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
                            <div v-show="imageType === 'current'">
                                <img :src="item.image_url" class="preview" alt="default">
                            </div>
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
                                <images-browse-table v-if="item.image !== null" :images="images" :active="{name: item.image, url: item.image_url}" @select="setImagePreviewBrowser"></images-browse-table>
                                <images-browse-table v-else :images="images" @select="setImagePreviewBrowser"></images-browse-table>
                            </div>
                        </div>
                    </div>

                    <v-text-field
                            v-if="item.type === 'item' || item.type === 'permgroup' || item.type === 'region_owner' || item.type === 'region_member'"
                            :label="$t(`content.admin.items.add.${item.type}_id`)"
                            prepend-icon="fingerprint"
                            v-model="item.signature"
                    ></v-text-field>
                    <v-text-field
                            v-if="item.type === 'command'"
                            :label="$t(`content.admin.items.add.command`)"
                            prepend-icon="keyboard_arrow_right"
                            v-model="item.signature"
                    ></v-text-field>
                    <div class="text-xs-center" v-if="item.type === 'item'">
                        <v-btn color="purple" dark @click.native.stop="enchantment = true">{{ $t('content.admin.items.add.enchantment.title') }}</v-btn>
                    </div>
                    <enchantment
                            :dialog="enchantment"
                            :enchantments="enchantments"
                            @close="closeEnchantmentDialog"
                    ></enchantment>
                    <v-text-field
                            v-if="item.type === 'item' || item.type === 'permgroup'"
                            :label="$t('content.admin.items.add.extra')"
                            prepend-icon="list"
                            v-model="item.extra"
                    ></v-text-field>
                    <v-layout align-center v-if="item.type === 'command'">
                        <v-checkbox
                                color="secondary"
                                v-model="patternEnabled"
                                hide-details class="shrink mr-2"
                        ></v-checkbox>
                        <v-text-field
                                :label="$t('content.admin.items.add.pattern')"
                                v-model="pattern"
                                :disabled="!patternEnabled"
                        ></v-text-field>
                    </v-layout>
                </v-card-text>
                <v-card-actions>
                    <v-btn flat color="orange" :disabled="finishDisabled" :loading="finishLoading" @click="perform">{{ $t('content.admin.items.edit.finish') }}</v-btn>
                </v-card-actions>
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
    import loader from './../../../core/http/loader'
    import Table from './ImagesBrowseTable.vue'
    import Enchantment from './Enchantment.vue'

    export default {
        data() {
            return {
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
                    },
                    {
                        text: $t('common.item.type.currency'),
                        value: 'currency',
                        icon: 'monetization_on'
                    },
                    {
                        text: $t('common.item.type.region_owner'),
                        value: 'region_owner',
                        icon: 'supervisor_account'
                    },
                    {
                        text: $t('common.item.type.region_member'),
                        value: 'region_member',
                        icon: 'person'
                    },
                    {
                        text: $t('common.item.type.command'),
                        value: 'command',
                        icon: 'keyboard_arrow_right'
                    }
                ],
                item: {
                    name: '',
                    description: null,
                    image: null,
                    type: null,
                    extra: null,
                    signature: ''
                },
                image: null,
                images: [],
                imageType: 'current',
                imagePreviewUpload: null,
                imagePreviewBrowser: null,
                imageBrowser: null,
                enchantment: false,
                enchantments: [],
                readyEnchantments: [],
                patternEnabled: true,
                pattern: '',
                finishLoading: false
            }
        },
        beforeRouteEnter (to, from, next) {
            loader.beforeRouteEnter(`/spa/admin/items/edit/${to.params.item}`, to, from, next);
        },
        beforeRouteUpdate (to, from, next) {
            loader.beforeRouteUpdate(`/spa/admin/items/edit/${to.params.item}`, to, from, next, this);
        },
        computed: {
            finishDisabled() {
                return this.item.name === '' || (this.item.type !== 'currency' && this.item.signature === '') ||
                    (this.item.type === 'command' && this.patternEnabled && this.pattern === '');
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
            closeEnchantmentDialog(readyEnchantments) {
                this.readyEnchantments = [];
                readyEnchantments.forEach(enchantment => {
                    if (enchantment.model > 0) {
                        this.readyEnchantments.push({
                            id: enchantment.id,
                            level: enchantment.model,
                        });
                    }
                });
                this.enchantment = false;
            },
            perform() {
                this.finishLoading = true;
                const data = this.image !== null ? this.image : new FormData();
                data.append('name', this.item.name);
                data.append('description', this.item.description !== null ? this.item.description : '');
                data.append('item_type', this.item.type);
                data.append('image_type', this.imageType);
                data.append('image_name', this.imageBrowser);
                data.append('signature',  this.item.signature !== null ? this.item.signature : '');
                data.append('enchantments', JSON.stringify(this.readyEnchantments));
                if (this.item.type === 'command') {
                    data.append('extra', this.patternEnabled ? this.pattern : '');
                } else {
                    data.append('extra', this.item.extra !== null ? this.item.extra : '');
                }

                this.$axios.post(`/spa/admin/items/edit/${this.$route.params.item}`, data)
                    .then((response) => {
                        if (response.data.status === 'success') {
                            this.$router.push({name: 'admin.items.list'});
                        } else {
                            this.finishLoading = false;
                        }
                    })
                    .catch(err => {
                        this.finishLoading = false;
                    });
            },
            setData(response) {
                const data = response.data;

                this.item = data.item;
                if (this.item.type === 'command') {
                    if (this.item.extra !== null) {
                        this.patternEnabled = true;
                        this.pattern = this.item.extra;
                    } else {
                        this.patternEnabled = false;
                    }
                }
                this.images = data.images;
                this.imageType = data.item.image === null ? 'default' : 'current';
                this.enchantments = data.enchantments;
            }
        },
        components: {
            'images-browse-table': Table,
            'enchantment': Enchantment
        }
    }
</script>
