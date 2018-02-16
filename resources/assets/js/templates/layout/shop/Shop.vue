<template>
    <div>
        <v-toolbar
                color="grey darken-1"
                dark
                temporary
                app
                clipped-right
        >
            <v-toolbar-side-icon @click.stop="drawer = !drawer" style></v-toolbar-side-icon>
            <v-toolbar-title>Сервер: MMO</v-toolbar-title>
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
            <profile-block v-if="$store.getters.isAuth" character="character"></profile-block>
            <admin-block v-if="adminSidebar.length !== 0" :items="adminSidebar"></admin-block>

        </v-navigation-drawer>
        <v-content>
            <v-container fluid fill-height>
                <v-layout justify-center align-center>
                    <v-flex shrink>

                    </v-flex>
                </v-layout>
            </v-container>
        </v-content>
        <v-navigation-drawer
                right
                temporary
                v-model="right"
                fixed
        ></v-navigation-drawer>
        <v-footer color="grey darken-2" class="white--text" inset app absolute height="40">
            <v-spacer></v-spacer>
            <span>2017-2018 &copy; L-Shop</span>
            <v-btn href="https://github.com/D3lph1/L-shop" target="_blank" small color="secondary">GitHub</v-btn>
            <v-spacer></v-spacer>
        </v-footer>
    </div>
</template>

<script>
    import loader from './../../../core/http/loader'
    import BasicBlock from './BasicBlock.vue'
    import ProfileBlock from './ProfileBlock.vue'
    import AdminBlock from './AdminBlock.vue'

    export default {
        data() {
            return {
                drawer: true,
                drawerRight: true,
                right: null,
                left: null,

                mobileBreakPoint: 1024,

                character: false,
                adminSidebar: []
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

                this.character = data.character;
                this.adminSidebar = data.sidebar.admin;
            }
        },
        components: {
            'basic-block': BasicBlock,
            'profile-block': ProfileBlock,
            'admin-block': AdminBlock
        }
    }
</script>
