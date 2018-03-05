<template>
    <div>
        <v-toolbar
                color="primary"
                dark
                temporary
                app
                clipped-right
        >
            <v-toolbar-side-icon @click.stop="drawer = !drawer" style></v-toolbar-side-icon>
            <v-toolbar-title>
                Сервер:
                <span v-if="server !== null">{{ server.name }}</span>
                <span v-else>{{ $t('content.frontend.shop.layout.server_not_selected') }}</span>
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-side-icon @click.stop="right = !right"><v-icon>library_books</v-icon></v-toolbar-side-icon>
        </v-toolbar>
        <v-navigation-drawer
                fixed
                v-model="drawer"
                app
                :mobile-break-point="mobileBreakPoint"
        >

            <basic-block></basic-block>
            <profile-block v-if="$store.getters.isAuth" :character="character"></profile-block>
            <admin-block v-if="adminSidebar.length !== 0" :items="adminSidebar"></admin-block>

        </v-navigation-drawer>
        <v-content>
            <div class="px-4 pt-4">
                <router-view name="content"></router-view>
            </div>
        </v-content>
        <v-navigation-drawer
                right
                temporary
                v-model="right"
                fixed
        >
            <news v-if="news !== null" :news="news"></news>
        </v-navigation-drawer>
        <v-footer color="primary" fixed class="white--text" inset app height="40">
            <settings></settings>
            <v-spacer></v-spacer>
            <span>2017-2018 &copy; L-Shop</span>
            <v-btn :href="github" target="_blank" small outline color="white">GitHub</v-btn>
            <v-spacer></v-spacer>
        </v-footer>
    </div>
</template>

<script>
    import loader from './../../../core/http/loader'
    import BasicBlock from './sidebar/BasicBlock.vue'
    import ProfileBlock from './sidebar/ProfileBlock.vue'
    import AdminBlock from './sidebar/AdminBlock.vue'
    import Settings from './sidebar/Settings.vue'
    import News from './news/Block.vue'

    export default {
        data() {
            return {
                drawer: true,
                drawerRight: true,
                right: null,
                left: null,

                mobileBreakPoint: 1024,

                character: false,
                server: null,
                adminSidebar: [],
                news: null,
                github: ''
            }
        },
        created() {
            this.configureLayout();
        },
        beforeRouteEnter (to, from, next) {
            loader.beforeRouteEnter('/api/shop', to, from, next);
        },
        beforeRouteUpdate (to, from, next) {
            loader.beforeRouteUpdate('/api/shop', to, from, next, this);
        },
        watch: {
            '$store.state.shop.server'(val) {
                this.server = val;
            }
        },
        methods: {
            configureLayout() {
                // Collapses the left drawer if the screen width is less than
                // the specified value.
                if (window.innerWidth <= this.mobileBreakPoint) {
                    this.drawer = false;
                }
            },
            setData(response) {
                const data = response.data;

                this.$store.commit('setCurrencyHtml', data.currency);
                this.character = data.character;
                this.adminSidebar = data.sidebar.admin;
                this.news = data.news;
                this.server = data.server;
                this.github = data.github;
                this.$store.commit('setBalance', data.auth.user.balance);
                this.$store.commit('setServer', data.server);
                this.$store.commit('setCartAmount', data.cart.amount);
            }
        },
        components: {
            'basic-block': BasicBlock,
            'profile-block': ProfileBlock,
            'admin-block': AdminBlock,
            'settings': Settings,
            'news': News
        }
    }
</script>