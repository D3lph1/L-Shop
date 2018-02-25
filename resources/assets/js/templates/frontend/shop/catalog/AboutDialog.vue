<template>
    <v-layout row justify-center>
        <v-dialog v-model="dialog" persistent max-width="500px">
            <v-card>
                <v-card-title>
                    <span class="headline">{{ $t('content.frontend.shop.catalog.about.title', {product: name}) }}</span>
                </v-card-title>
                <v-card-text>
                    <v-container class="text-xs-center">
                        <img :src="image" class="product-image" :alt="name">
                    </v-container>
                    <v-container class="text-xs-center subheading" v-if="!description">
                        {{ $t('content.frontend.shop.catalog.about.description.empty') }}
                    </v-container>
                    <v-container v-else>
                        <p class="text-xs-center subheading">{{ $t('content.frontend.shop.catalog.about.description.title') }}</p>
                        <div v-html="description"></div>
                    </v-container>
                    <v-container>
                        <v-layout>
                            <v-flex xs6>{{ $t('content.frontend.shop.catalog.about.type') }}</v-flex>
                            <v-flex xs6 class="text-xs-right">
                                <span v-if="isItem">
                                    {{ $t('common.item.type.item') }}
                                </span>
                                <span v-else-if="isPermgroup">
                                    {{ $t('common.item.type.permgroup') }}
                                </span>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" flat @click.native="$emit('close')">{{ $t('common.cancel') }}</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-layout>
</template>

<script>
    export default {
        props: {
            dialog: {
                required: true,
                type: Boolean
            },
            name: {
                required: true,
                type: String
            },
            description: {
                required: true,
            },
            image: {
                required: true,
                type: String
            },
            isItem: {
                required: true,
                type: Boolean
            },
            isPermgroup: {
                required: true,
                type: Boolean
            }
        },
    }
</script>

<style lang="sass" scoped>
    .product-image
        max-width: 150px
</style>
