<template>
    <v-layout row justify-center>
        <v-dialog v-model="dialogData" max-width="800px">
            <v-card>
                <v-card-title>
                    <span class="headline">{{ $t('content.layout.shop.monitoring.title') }}</span>
                </v-card-title>
                <v-card-text>
                    <v-layout wrap align-center justify-center>
                        <v-flex v-for="(each, index) in monitoring" :key="index" xs12 sm6 md4 class="text-xs-center">
                            <v-progress-circular
                                    v-if="each.isDisabled"
                                    :size="150"
                                    :width="20"
                                    :rotate="90"
                                    :value="100"
                                    color="warning"
                            >
                                {{ $t('content.layout.shop.monitoring.disabled') }}
                            </v-progress-circular>

                            <v-progress-circular
                                    v-else-if="each.isFailed"
                                    :size="150"
                                    :width="20"
                                    :rotate="90"
                                    :value="100"
                                    color="red"
                            >
                                {{ $t('content.layout.shop.monitoring.failed') }}
                            </v-progress-circular>

                            <v-progress-circular
                                    v-else
                                    :size="150"
                                    :width="20"
                                    :rotate="90"
                                    :value="(each.now / each.total) * 100"
                                    color="secondary"
                            >
                                {{ each.now }} / {{ each.total }}
                            </v-progress-circular>

                            <p class="subheading mt-1">{{ each.server.name }}</p>
                        </v-flex>
                    </v-layout>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" flat @click.native="dialogData = false">{{ $t('common.close') }}</v-btn>
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
            monitoring: {
                required: true,
                type: Array
            }
        },
        data() {
            return {
                dialogData: this.dialog,
                models: []
            }
        },
        watch: {
            dialog(val) {
                this.dialogData = val;
            },
            dialogData(val) {
                if (val === false) {
                    this.$emit('close', this.models);
                }
            },
        }
    }
</script>
