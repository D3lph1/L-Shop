<template>
    <div id="server-block">
        <button id="chose-server" class="btn btn-warning btn-block" @click="click">
            <i class="fa fa-chevron-right fa-left left"></i> {{ title }}
        </button>
        <div id="server-list" class="servers text-left">
            <a v-for="server in servers" class="waves-effect white-text" :href="server.url">
                <i v-if="!server.enabled" :class="'fa fa-power-off fa-left'" :title="$t('content.monitoring.server_disabled')"></i>
                {{ server.name }}
            </a>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['title', 'servers'],
        data() {
            return {
                visible: false
            }
        },
        methods: {
            click: function () {
                switch (this.visible) {
                    case true:
                        document.getElementById('server-list').style.transform = 'translateX(-150%)';
                        document.getElementById('chose-server').getElementsByTagName('I')[0].style.transform = 'rotateZ(0deg)';
                        this.visible = false;
                        break;
                    case false:
                        document.getElementById('server-list').style.transform = 'translateX(0)';
                        document.getElementById('chose-server').getElementsByTagName('I')[0].style.transform = 'rotateZ(180deg)';
                        this.visible = true;
                }
            }
        }
    }
</script>