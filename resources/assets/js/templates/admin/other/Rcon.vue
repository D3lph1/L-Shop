<template>
    <div id="rcon">
        <div id="rcon-header">
            <h1 class="headline">{{ $t('content.admin.other.rcon.title') }}</h1>
            <v-spacer></v-spacer>
            <div id="select-wrapper">
                <v-select
                        single-line
                        v-model="server"
                        :items="servers"
                        label="Choose server"
                        item-value="id"
                        item-text="name"
                ></v-select>
            </div>
        </div>
        <div id="command-field">
            <p class="console-line" v-for="command in commands">
                <v-icon class="console-icon">navigate_next</v-icon>
                <span v-html="command.text"></span> <span class="command-date">{{ command.date }}</span>
            </p>
        </div>
        <div id="command-line">
            <v-text-field
                    v-model="command"
                    :label="$t('content.admin.other.rcon.input')"
                    append-icon="send"
                    :append-icon-cb="sendCommand"
                    prepend-icon="chevron_right"
                    :disabled="server === null"
                    @keyup.enter="sendCommand"
            ></v-text-field>
        </div>
    </div>
</template>

<script>
    import loader from './../../../core/http/loader'

    export default {
        data() {
            return {
                command: '',
                server: null,
                servers: [],
                commands: []
            }
        },
        beforeRouteEnter(to, from, next) {
            loader.beforeRouteEnter('/spa/admin/other/rcon', to, from, next);
        },
        beforeRouteUpdate(to, from, next) {
            loader.beforeRouteUpdate('/spa/admin/other/rcon', to, from, next, this);
        },
        methods: {
            sendCommand() {
                if (this.command !== '' && this.server !== null) {
                    this.commands.unshift({
                        text: this.command,
                        date: new Date().toLocaleTimeString()
                    });
                    const command = this.command;
                    this.command = '';

                    this.$axios.post('/spa/admin/other/rcon', {
                        server: this.server,
                        command
                    })
                        .then(response => {
                            this.commands.unshift({
                                text: response.data.response,
                                date: new Date().toLocaleTimeString()
                            });
                        });
                }
            },
            setData(response) {
                const data = response.data;

                this.servers = data.servers;
            }
        }
    }
</script>

<style lang="less" scoped>
    #rcon {
        max-width: 800px;
        margin: 0 auto;
        #rcon-header {
            #select-wrapper {
                width: 200px;
            }
        }
        #command-field {
            width: 100%;
            height: 300px;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #333;
            border-radius: 2px;
            overflow-y: scroll;
            -webkit-box-shadow: 0 2px 5px -1px rgba(0, 0, 0, 0.75);
            -moz-box-shadow: 0 2px 5px -1px rgba(0, 0, 0, 0.75);
            box-shadow: 0 2px 5px -1px rgba(0, 0, 0, 0.75);
            &::-webkit-scrollbar {
                width: 0;
            }
            .console-line, .console-error {
                color: #ddd;
                position: relative;
                padding-left: 15px;
                padding-right: 65px;
                margin: 0 0 3px 0;
                word-wrap: break-word;
                line-height: 1.4;
                font-size: 15px;
                .console-icon {
                    color: #ffffff;
                    margin-left: -22px;
                    position: absolute;
                    transform: scale(0.8, 0.8);
                    top: -2px;
                }
                .command-date {
                    position: absolute;
                    top: 0;
                    right: 0;
                    color: #27ae60;
                }
            }
            .console-error {
                color: #e74c3c;
            }
        }
        #command-line {
            display: flex;
        }
    }
</style>
