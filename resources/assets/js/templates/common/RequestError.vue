<template>
    <v-dialog v-model="visible" persistent max-width="290">
        <v-card>
            <v-card-title class="headline">{{ $t('msg.request_error.title') }}</v-card-title>
            <v-card-text>{{ $t('msg.request_error.notify') }}</v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="red darken-1" flat @click.native="main">{{ $t('msg.request_error.main') }}</v-btn>
                <v-btn color="red darken-1" flat @click.native="back">{{ $t('msg.request_error.back') }}</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    export default {
        computed: {
            visible() {
                return this.$store.state.requestError;
            }
        },
        methods: {
            main() {
                this.$store.commit('dismissRequestError');
                this.$router.replace({name: 'frontend.auth.login'});
            },
            back() {
                this.$store.commit('dismissRequestError');
                this.$router.go(-1);
            }
        }
    }
</script>
