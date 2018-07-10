<template>
    <v-container
            id="full"
            fluid
            align-center
            justify-center
    >
        <v-card
                id="enter-card"
                width="300px"
        >
            <v-card
                    id="form-header"
                    color="primary"
            >
                <v-icon medium color="white">check_circle</v-icon>
                <h1>{{ $t('content.frontend.auth.servers.title') }}</h1>
            </v-card>

            <v-list>
                <v-list-tile
                        avatar
                        v-for="(server, index) in servers"
                        :key="index"
                        :to="{name: server.route, params: {server: server.id}}"
                        @contextmenu="contextMenu($event, server)"
                >
                    <v-list-tile-action>
                        <v-icon v-if="!server.enabled">power_settings_new</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <v-list-tile-title v-text="server.name"></v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
            </v-list>

            <v-menu
                    offset-y
                    v-model="menu.show"
                    absolute
                    :position-x="menu.x"
                    :position-y="menu.y"
            >
                <v-list>
                    <v-list-tile v-for="(item, index) in menu.items" :key="index" @click="contextMenuClick(item)">
                        <v-list-tile-title>{{ item.title }}</v-list-tile-title>
                    </v-list-tile>
                </v-list>
            </v-menu>

            <v-footer
                    height="auto"
                    id="form-footer"
            >
                <v-tooltip bottom v-if="isAuth">
                    <v-btn
                            large
                            outline
                            icon
                            color="blue"
                            slot="activator"
                            :disabled="disabledLogoutBtn"
                            @click="logout"
                    >
                        <v-icon>exit_to_app</v-icon>
                    </v-btn>
                    <span>{{ $t('content.frontend.auth.login.logout') }}</span>
                </v-tooltip>
                <v-tooltip bottom v-else-if="!isAuth && allowLogin">
                    <v-btn
                            large
                            outline
                            icon
                            color="blue"
                            slot="activator"
                            :to="{name: 'frontend.auth.login'}"
                    >
                        <v-icon>vpn_key</v-icon>
                    </v-btn>
                    <span>{{ $t('content.frontend.auth.login.title') }}</span>
                </v-tooltip>
            </v-footer>
        </v-card>
    </v-container>
</template>

<script>
    import loader from './../../../core/http/loader'

    export default {
        data() {
            return {
                // Servers list.
                servers: [],
                // Is the user authorized to authenticate.
                allowLogin: false,
                menu: {
                    // The current status of the context menu. True - displayed, false - hidden.
                    show: false,
                    // Horizontal coordinate of context menu.
                    x: 0,
                    // Vertical coordinate of context menu.
                    y: 0,
                    // The server object on which the context menu was called.
                    clicked: null,
                    // List of context menu items.
                    items: []
                },

                disabledLogoutBtn: false
            }
        },
        beforeRouteEnter (to, from, next) {
            loader.beforeRouteEnter('/spa/servers', to, from, next);
        },
        beforeRouteUpdate (to, from, next) {
            loader.beforeRouteUpdate('/spa/servers', to, from, next, this);
        },
        computed: {
            disabledBtn() {
                return !this.check();
            },
            isAuth() {
                return this.$store.getters.isAuth;
            }
        },
        methods: {
            contextMenu(event, server) {
                event.preventDefault();
                this.menu.show = false;
                this.menu.x = event.clientX;
                this.menu.y = event.clientY;
                this.menu.clicked = server;
                this.$nextTick(() => {
                    this.menu.show = true
                })
            },
            contextMenuClick(listItem) {
                if (this.menu.clicked === null) {
                    return;
                }

                switch (listItem.action) {
                    case 'edit':
                        this.$router.push({name: 'admin.servers.edit', params: {server: this.menu.clicked.id}});
                        break;
                    case 'switch':
                        const self = this;
                        function onComplete(response) {
                            if (response.data.status === 'success') {
                                self.menu.clicked.enabled = !self.menu.clicked.enabled;
                            }
                        }

                        if (this.menu.clicked.enabled) {
                            this.$axios.post(`/spa/admin/servers/disable/${this.menu.clicked.id}`)
                                .then(onComplete);
                        } else {
                            this.$axios.post(`/spa/admin/servers/enable/${this.menu.clicked.id}`)
                                .then(onComplete);
                        }
                        break;
                }
            },
            logout() {
                this.disabledLogoutBtn = true;
                this.$axios.post('/spa/logout')
                    .then((response) => {
                        if (response.data.status === 'success') {
                            this.$notification.info($t('msg.frontend.auth.logout.success'));
                            this.$router.replace({name: 'frontend.auth.login'});
                            this.$store.commit('logout');
                            this.disabledLogoutBtn = false;
                        }
                    });
            },
            setData(response) {
                const data = response.data;

                this.servers = data.servers;
                this.allowLogin = data.allowLogin;
                if (data.canServersCrud) {
                    this.menu.items.push({
                        title: 'Редактировать',
                        action: 'edit'
                    });
                }

                if (data.canEnableDisableServers) {
                    this.menu.items.push({
                        title: 'Переключить',
                        action: 'switch'
                    });
                }
            }
        }
    }
</script>
