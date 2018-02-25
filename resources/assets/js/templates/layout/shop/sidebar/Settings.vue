<template>
    <div>
        <v-btn color="white" icon flat small @click="dialog = true">
            <v-icon small>settings</v-icon>
        </v-btn>

        <v-dialog v-model="dialog" fullscreen transition="dialog-bottom-transition" :overlay="false">
            <v-card>
                <v-toolbar dark color="primary">
                    <v-btn icon @click.native="dialog = false" dark>
                        <v-icon>close</v-icon>
                    </v-btn>
                    <v-toolbar-title>{{ $t('content.layout.shop.settings.title') }}</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-toolbar-items>
                        <v-btn dark flat @click.native="dialog = false">{{ $t('common.save') }}</v-btn>
                    </v-toolbar-items>
                </v-toolbar>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                dialog: false
            }
        }
    }
</script>

