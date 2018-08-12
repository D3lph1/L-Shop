<template>
    <shop-grid>
        <server-card
                v-for="server in servers"
                :key="server.id"
                :id="server.id"
                :name="server.name"
                :categories="server.categories"
                @delete="deleteServer"
        ></server-card>
    </shop-grid>
</template>

<script>
    import loader from './../../../core/http/loader'
    import ServerCard from './ServerCard.vue'
    import ShopGrid from './../../layout/shop/Grid.vue'

    export default {
        data() {
            return {
                servers: []
            }
        },
        beforeRouteEnter(to, from, next) {
            loader.beforeRouteEnter('/spa/admin/servers/list', to, from, next);
        },
        beforeRouteUpdate(to, from, next) {
            loader.beforeRouteUpdate('/spa/admin/servers/list', to, from, next, this);
        },
        methods: {
            deleteServer(id) {
                this.servers.forEach((each, index) => {
                    if (each.id === id) {
                        this.servers.splice(index, 1);
                    }
                });
            },
            setData(response) {
                const data = response.data;

                this.servers = data.servers;
            }
        },
        components: {
            'shop-grid': ShopGrid,
            'server-card': ServerCard
        }
    }
</script>
