<template>
    <v-card hover class="server-card">
        <v-card-title class="server-title">
            <span class="subheading">{{ name }}</span>
            <v-spacer></v-spacer>
            <v-tooltip top>
                <span class="caption" slot="activator">{{ id }}</span>
                <span>{{ $t('content.admin.servers.list.server_id') }}</span>
            </v-tooltip>
        </v-card-title>

        <v-divider></v-divider>

        <v-list subheader class="server-category-list">
            <v-subheader>{{ $t('content.admin.servers.list.categories') }}</v-subheader>
            <v-list-tile
                    v-for="category in categories"
                    :key="category.id"
                    :to="{name: 'frontend.shop.catalog.category', params: {server: id, category: category.id}}"
            >
                <v-list-tile-content>
                    <v-list-tile-title class="server-category">
                        <v-icon>navigate_next</v-icon> {{ category.name }}
                    </v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>
        </v-list>

        <v-card-actions class="server-footer">
            <v-tooltip bottom>
                <v-btn
                        class="product-btn"
                        icon
                        flat
                        outline
                        color="secondary"
                        slot="activator"
                        :to="{name: 'frontend.shop.catalog', params: {server: id}}"
                >
                    <v-icon>link</v-icon>
                </v-btn>
                <span>{{ $t('content.admin.servers.list.go_to_server') }}</span>
            </v-tooltip>
            <v-spacer></v-spacer>

            <v-tooltip bottom>
                <v-btn
                        class="product-btn"
                        icon
                        flat
                        outline
                        color="primary"
                        slot="activator"
                        :to="{name: 'admin.servers.edit', params: {server: id}}"
                >
                    <v-icon>edit</v-icon>
                </v-btn>
                <span>{{ $t('common.edit') }}</span>
            </v-tooltip>

            <v-tooltip bottom>
                <v-btn
                        class="product-btn"
                        icon
                        flat
                        outline
                        color="red"
                        slot="activator"
                        @click="deleteServer"
                >
                    <v-icon>delete</v-icon>
                </v-btn>
                <span>{{ $t('common.delete') }}</span>
            </v-tooltip>
        </v-card-actions>
    </v-card>
</template>

<script>
    export default {
        props: {
            id: {
                required: true,
                type: Number
            },
            name: {
                required: true,
                type: String
            },
            categories: {
                required: true,
                type: Array
            }
        },
        methods: {
            deleteServer() {
                if (confirm($t('content.admin.servers.list.delete', {name: this.name}))) {
                    this.$axios.post(`/spa/admin/servers/delete/${this.id}`, {
                        _method: 'DELETE'
                    })
                        .then(response => {
                            if (response.data.status === 'success') {
                                if (response.data.destroyPersistence) {
                                    this.$store.state.shop.server = null;
                                }
                                this.$emit('delete', this.id);
                            }
                        });
                }
            }
        }
    }
</script>

<style lang="less" scoped>
    .server-card {
        width: 100%;
        max-width: 250px;
        .server-title {
            padding: 10px 15px;
        }
        .server-category-list {
            padding-bottom: 52px;
            .server-category {
                display: flex;
                align-items: center;
            }
        }
        .server-footer {
            position: absolute;
            bottom: 0;
            right: 0;
            left: 0;
            border-top: 1px solid rgba(0,0,0,.12);
            display: flex;
            align-items: center;
            background-color: #f5f5f5;		}
    }
</style>
