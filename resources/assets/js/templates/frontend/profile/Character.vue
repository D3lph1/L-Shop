<template>
    <v-card>
        <v-container>
            <v-layout row wrap>
                <v-flex xs12 sm12 md6 lg6 class="text-xs-center mt-5">
                    <v-layout row wrap>
                        <v-flex xs12>
                            <img :src="skin.front" alt="">
                            <img :src="skin.back" alt="">
                        </v-flex>
                        <v-flex xs12 class="text-xs-center mt-2">
                            <v-uploader class="uploader" accept="image/png"></v-uploader>
                        </v-flex>
                        <v-flex xs12 class="text-xs-center mt-2">
                            <v-btn color="success">{{ $t('content.frontend.profile.character.upload') }}</v-btn>
                            <v-btn color="error"><v-icon>delete</v-icon></v-btn>
                        </v-flex>
                    </v-layout>
                </v-flex>
                <v-flex xs12 sm12 md6 lg6 class="text-xs-center mt-5">
                    <v-layout row wrap>
                        <v-flex xs12>
                            <img :src="cloak.front" alt="">
                            <img :src="cloak.back" alt="">
                        </v-flex>
                        <v-flex xs12 class="text-xs-center mt-2">
                            <v-uploader class="uploader" accept="image/png"></v-uploader>
                        </v-flex>
                        <v-flex xs12 class="text-xs-center mt-2">
                            <v-btn color="success">{{ $t('content.frontend.profile.character.upload') }}</v-btn>
                            <v-btn color="error"><v-icon>delete</v-icon></v-btn>
                        </v-flex>
                    </v-layout>
                </v-flex>
            </v-layout>
        </v-container>
    </v-card>
</template>

<script>
    import loader from './../../../core/http/loader'

    export default {
        data() {
            return {
                skin: {
                    front: null,
                    back: null
                },
                cloak: {
                    front: null,
                    back: null
                }
            }
        },
        beforeRouteEnter(to, from, next) {
            loader.beforeRouteEnter('/api/profile/character', to, from, next);
        },
        beforeRouteUpdate(to, from, next) {
            loader.beforeRouteUpdate('/api/profile/character', to, from, next, this);
        },
        methods: {
            setData(response) {
                const data = response.data;

                this.skin.front = data.skin.front;
                this.skin.back = data.skin.back;
                this.cloak.front = data.cloak.front;
                this.cloak.back = data.cloak.back;
            }
        },
    }
</script>

<style lang="sass" scoped>
    .uploader
        width: 200px
        display: inline-block;
</style>
