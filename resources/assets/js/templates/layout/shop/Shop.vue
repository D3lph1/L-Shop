<template>
    <div>
        <v-toolbar
                color="primary"
                dark
                app
        >
            <v-toolbar-side-icon @click.stop="drawer = !drawer" style></v-toolbar-side-icon>
            <v-toolbar-title>
                {{ $t('content.layout.shop.server') }}
                <span v-if="server !== null">{{ server.name }}</span>
                <span v-else>{{ $t('content.frontend.shop.layout.server_not_selected') }}</span>
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-side-icon v-if="monitoring.length !== 0" @click="monitoringDialog = true"><v-icon>insert_chart</v-icon></v-toolbar-side-icon>
            <v-toolbar-side-icon v-show="newsAllowed" @click.stop="right = !right"><v-icon>library_books</v-icon></v-toolbar-side-icon>
        </v-toolbar>
        <v-navigation-drawer
                v-model="drawer"
                class="drawer"
                app
                floating
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
                v-show="newsAllowed"
                app
                v-model="right"
                class="drawer"
                id="news-drawer"
                right
                temporary
        >
            <aside-news v-if="newsAllowed" :news="news"></aside-news>
        </v-navigation-drawer>
        <v-footer color="primary" fixed class="white--text" inset app height="40">
            <settings></settings>
            <v-spacer></v-spacer>
            <span>2017-2018 &copy; L-Shop</span>
            <v-btn :href="github" target="_blank" small outline color="white">GitHub</v-btn>
            <v-spacer></v-spacer>
        </v-footer>

        <monitoring-dialog
                :dialog="monitoringDialog"
                :monitoring="monitoring"
                @close="closeMonitoringDialog"
        ></monitoring-dialog>
    </div>
</template>

<script>
    import loader from './../../../core/http/loader'
    import BasicBlock from './sidebar/BasicBlock.vue'
    import ProfileBlock from './sidebar/ProfileBlock.vue'
    import AdminBlock from './sidebar/AdminBlock.vue'
    import Settings from './sidebar/Settings.vue'
    import AsideNews from './AsideNews.vue'
    import MonitoringDialog from './MonitoringDialog.vue'

    export default {
        data() {
            return {
                drawer: true,
                drawerRight: true,
                right: null,
                left: null,

                mobileBreakPoint: 1024,
                monitoring: [],
                monitoringDialog: false,

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
            loader.beforeRouteEnter('/spa/shop', to, from, next);
        },
        beforeRouteUpdate (to, from, next) {
            loader.beforeRouteUpdate('/spa/shop', to, from, next, this);
        },
        watch: {
            '$store.state.shop.server'(val) {
                this.server = val;
            }
        },
        computed: {
            newsAllowed() {
                return this.news !== null && this.$store.state.shop.news.enabled;
            }
        },
        mounted() {
            this.$axios.get('/spa/monitoring')
                .then(response => {
                    if (response.data.status === 'success') {
                        this.monitoring = response.data.monitoring;
                    }
                });
        },
        methods: {
            configureLayout() {
                // Collapses the left drawer if the screen width is less than
                // the specified value.
                if (window.innerWidth <= this.mobileBreakPoint) {
                    this.drawer = false;
                }
            },
            closeMonitoringDialog() {
                this.monitoringDialog = false;
            },
            setData(response) {
                const data = response.data;

                this.$store.commit('setCurrencyPlain', data.currency.plain);
                this.$store.commit('setCurrencyHtml', data.currency.html);
                this.character = data.character;
                this.adminSidebar = data.sidebar.admin;
                data.news.enabled ? this.$store.commit('enableNews') : this.$store.commit('disableNews');
                this.news = data.news.portion;
                this.server = data.server;
                this.github = data.github;
                this.$store.commit('setBalance', data.auth.user.balance);
                this.$store.commit('setServer', data.server);
                this.$store.commit('setCartAmount', data.cart.amount);
            }
        },
        components: {
            AsideNews,
            'basic-block': BasicBlock,
            'profile-block': ProfileBlock,
            'admin-block': AdminBlock,
            'settings': Settings,
            'aside-news': AsideNews,
            'monitoring-dialog': MonitoringDialog
        }
    }
</script>
