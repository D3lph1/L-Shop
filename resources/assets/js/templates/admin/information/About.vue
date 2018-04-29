<template>
    <v-container>
        <div id="logo-block">
            <div class="logo-img">
                <img :src="images.logo" alt="logo" class="c-logo">
            </div>
            <div class="logo-text">
                <h1 class="display-3 grey--text text--darken-3">L-Shop</h1>
            </div>
        </div>
        <p class="subheading" v-html="$t('content.admin.information.about.description')"></p>
            <div class="text-xs-center mt-5">
                <a :href="github" target="_blank" class="l-shop-version" title="GitHub">
                    <v-chip outline color="primary" style="cursor: pointer !important;">
                        <v-avatar>
                            <img :src="images.logo" class="cp" alt="L-Shop logo">
                        </v-avatar>
                        <span class="cp">{{ $t('content.admin.information.about.lshop_version', {version}) }}</span>
                    </v-chip>
                </a>
            </div>
        <v-layout row wrap align-center justify-center class="mt-5">
            <v-flex xs6 sm4 md4 lg4>
                <v-tooltip bottom>
                    <div class="product-logo" slot="activator">
                        <img height="70" :src="images.laravel" alt="Laravel logo">
                        <div class="logo-text"><h1 class="title grey--text text--darken-3">Laravel</h1></div>
                    </div>
                    <span>{{ $t('content.admin.information.about.version', {version: '5.5.36'}) }}</span>
                </v-tooltip>
            </v-flex>
            <v-flex xs6 sm4 md4 lg4>
                <v-tooltip bottom>
                    <div class="product-logo" slot="activator">
                        <img height="70" :src="images.vue" alt="Vue logo">
                        <div class="logo-text"><h1 class="title grey--text text--darken-3">Vue.js</h1></div>
                    </div>
                    <span>{{ $t('content.admin.information.about.version', {version: '2.5.13'}) }}</span>
                </v-tooltip>
            </v-flex>
            <v-flex xs6 sm4 md4 lg4>
                <v-tooltip bottom>
                    <div class="product-logo" slot="activator">
                        <img height="70" :src="images.doctrine" alt="Doctrine logo">
                        <div class="logo-text"><h1 class="title grey--text text--darken-3">Doctrine ORM</h1></div>
                    </div>
                    <span>{{ $t('content.admin.information.about.version', {version: '2.5.14'}) }}</span>
                </v-tooltip>
            </v-flex>
            <v-flex xs6 sm4 md4 lg4>
                <v-tooltip bottom>
                    <div class="product-logo" slot="activator">
                        <img height="70" :src="images.vuetify" alt="Doctrine logo">
                        <div class="logo-text"><h1 class="title grey--text text--darken-3">Vuetify</h1></div>
                    </div>
                    <span>{{ $t('content.admin.information.about.version', {version: '1.0.13'}) }}</span>
                </v-tooltip>
            </v-flex>
        </v-layout>

        <v-list two-line class="mt-5">
            <template v-for="(item, index) in items">
                <v-subheader v-if="item.header" :key="item.header">{{ item.header }}</v-subheader>
                <v-divider v-else-if="item.divider" :inset="item.inset" :key="index"></v-divider>
                <v-list-tile avatar v-else @click="" :key="item.title" :title="item.subtitlePlain">
                    <v-list-tile-avatar>
                        <img :src="item.avatar">
                    </v-list-tile-avatar>
                    <v-list-tile-content>
                        <v-list-tile-title v-html="item.title"></v-list-tile-title>
                        <v-list-tile-sub-title v-html="item.subtitle"></v-list-tile-sub-title>
                    </v-list-tile-content>
                </v-list-tile>
            </template>
        </v-list>
    </v-container>
</template>

<script>
    import loader from './../../../core/http/loader'

    export default {
        data() {
            return {
                images: {
                    logo: null,
                    laravel: null,
                    vue: null,
                    doctrine: null,
                    vuetify: null,
                    github: null
                },
                version: null,
                items: [
                    {
                        header: $t('content.admin.information.about.developers_title')
                    },
                    {
                        avatar: null,
                        title: 'D3lph1 <a href="https://vk.com/d3lph1" target="_blank">vk</a> <a href="http://rubukkit.org/members/d3lph1.94641" target="_blank">rubukkit</a> <a href="https://github.com/D3lph1" target="_blank">github</a>',
                        subtitle: $t('content.admin.information.about.developers.D3lph1.description.html'),
                        subtitlePlain: $t('content.admin.information.about.developers.D3lph1.description.plain'),
                    },
                    {
                        divider: true,
                        inset: true
                    },
                    {
                        avatar: null,
                        title: 'WhileD0S <a href="https://vk.com/whiled0s" target="_blank">vk</a>',
                        subtitle: $t('content.admin.information.about.developers.WhileD0S.description.html'),
                        subtitlePlain: $t('content.admin.information.about.developers.WhileD0S.description.plain')
                    },
                ]
            }
        },
        beforeRouteEnter (to, from, next) {
            loader.beforeRouteEnter('/spa/admin/information/about', to, from, next);
        },
        beforeRouteUpdate (to, from, next) {
            loader.beforeRouteUpdate('/spa/admin/information/about', to, from, next, this);
        },
        methods: {
            setData(response) {
                const data = response.data;

                this.logo = data.logo;
                this.version = data.version;
                this.github = data.github;
                this.images = data.images;
                this.items[1].avatar = data.developers.d3lph1;
                this.items[3].avatar = data.developers.whileD0S;
            }
        }
    }
</script>

<style lang="sass" scoped>
    .l-shop-version
        text-decoration: none
        cursor: pointer
    .product-logo
        cursor: pointer
        padding: 1rem
        display: -webkit-flex
        display: -ms-flex
        display: flex
        margin-bottom: 1rem
        justify-content: center
        flex-wrap: wrap
        .logo-text
            justify-content: center
            align-self: center
            margin: 0 1rem
</style>
