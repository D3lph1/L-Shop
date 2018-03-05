<template>
    <v-card>
        <v-container>
            <v-layout row wrap>
                <v-flex xs12 sm12 md6 lg6 class="text-xs-center mt-5" v-if="skin.allowed">
                    <v-layout row wrap align-center justify-center>
                        <v-flex xs12>
                            <img :src="skin.front" alt="Front side of skin">
                            <img :src="skin.back" alt="Back side of skin">
                        </v-flex>
                        <v-flex xs12 class="text-xs-center mt-2">
                            <v-uploader class="uploader" accept="image/png" @formData="setUploadableSkin"></v-uploader>
                        </v-flex>
                        <v-flex xs12 class="text-xs-center mt-2">
                            <v-btn color="success" :disabled="uploadSkinDisabled" :loading="skin.uploadLoading" @click="uploadSkin">{{ $t('content.frontend.profile.character.upload') }}</v-btn>
                            <v-btn color="error" :disabled="skin.default" :loading="skin.deleteLoading" @click="deleteSkin"><v-icon>delete</v-icon></v-btn>
                        </v-flex>
                        <v-flex xs11 class="mt-4">
                            <v-alert type="info" outline :value="true">{{ $t('content.frontend.profile.character.skin.image_resolutions', {resolutions: skin.resolutions}) }}</v-alert>
                        </v-flex>
                        <v-flex xs11>
                            <v-alert type="info" outline :value="true">{{ $t('content.frontend.profile.character.skin.file_size', {size: skin.fileSize}) }}</v-alert>
                        </v-flex>
                    </v-layout>
                </v-flex>
                <v-flex xs12 sm12 md6 lg6 class="text-xs-center mt-5" v-if="cloak.allowed">
                    <v-layout row wrap align-center justify-center>
                        <v-flex xs12 v-if="cloak.exists">
                            <img :src="cloak.front" alt="Front side of cloak">
                            <img :src="cloak.back" alt="Back side of cloak">
                        </v-flex>
                        <v-flex xs12 v-else>
                            <v-alert type="info" outline :value="true">{{ $t('content.frontend.profile.character.cloak.not_set') }}</v-alert>
                        </v-flex>
                        <v-flex xs12 class="text-xs-center mt-2">
                            <v-uploader class="uploader" accept="image/png" @formData="setUploadableCloak"></v-uploader>
                        </v-flex>
                        <v-flex xs12 class="text-xs-center mt-2">
                            <v-btn color="success" :disabled="uploadCloakDisabled" :loading="cloak.uploadLoading" @click="uploadCloak">{{ $t('content.frontend.profile.character.upload') }}</v-btn>
                            <v-btn color="error" :disabled="!cloak.exists" :loading="cloak.deleteLoading" @click="deleteCloak"><v-icon>delete</v-icon></v-btn>
                        </v-flex>
                        <v-flex xs11 class="mt-4">
                            <v-alert type="info" outline :value="true">{{ $t('content.frontend.profile.character.cloak.image_resolutions', {resolutions: cloak.resolutions}) }}</v-alert>
                        </v-flex>
                        <v-flex xs11>
                            <v-alert type="info" outline :value="true">{{ $t('content.frontend.profile.character.cloak.file_size', {size: cloak.fileSize}) }}</v-alert>
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
                    allowed: false,
                    front: null,
                    back: null,
                    upload: null,
                    default: false,
                    uploadLoading: false,
                    deleteLoading: false,
                    resolutions: '',
                    fileSize: ''
                },
                cloak: {
                    allowed: false,
                    front: null,
                    back: null,
                    upload: null,
                    exists: false,
                    uploadLoading: false,
                    deleteLoading: false,
                    resolutions: '',
                    fileSize: ''
                }
            }
        },
        beforeRouteEnter(to, from, next) {
            loader.beforeRouteEnter('/api/profile/character', to, from, next);
        },
        beforeRouteUpdate(to, from, next) {
            loader.beforeRouteUpdate('/api/profile/character', to, from, next, this);
        },
        computed: {
            uploadSkinDisabled() {
                return this.skin.upload === null || this.skin.upload.get('file') === null;
            },
            uploadCloakDisabled() {
                return this.cloak.upload === null || this.cloak.upload.get('file') === null;
            },
        },
        methods: {
            setUploadableSkin(form) {
                this.skin.upload = form;
            },
            setUploadableCloak(form) {
                this.cloak.upload = form;
            },
            uploadSkin() {
                this.skin.uploadLoading = true;
                this.$axios.post('/api/profile/character/skin/upload', this.skin.upload, {headers: { 'content-type': 'multipart/form-data' }})
                    .then(response => {
                        this.skin.uploadLoading = false;
                        if (response.data.status === 'success') {
                            this.skin.default = false;
                            this.changeSkin();
                        }
                    });
            },
            deleteSkin() {
                this.skin.deleteLoading = true;
                this.$axios.post('/api/profile/character/skin/delete')
                    .then(response => {
                        this.skin.deleteLoading = false;
                        if (response.data.status === 'success') {
                            this.skin.default = true;
                            this.changeSkin();
                        }
                    });
            },
            uploadCloak() {
                this.cloak.uploadLoading = true;
                this.$axios.post('/api/profile/character/cloak/upload', this.cloak.upload)
                    .then(response => {
                        this.cloak.uploadLoading = false;
                        if (response.data.status === 'success') {
                            this.cloak.exists = true;
                            this.changeCloak();
                        }
                    });
            },
            deleteCloak() {
                this.cloak.deleteLoading = true;
                this.$axios.post('/api/profile/character/cloak/delete')
                    .then(response => {
                        this.cloak.deleteLoading = false;
                        if (response.data.status === 'success') {
                            this.cloak.exists = false;
                            this.changeCloak();
                        }
                    });
            },
            changeSkin() {
                this.skin.front = `${this.skin.front}?${Math.random()}`;
                this.skin.back = `${this.skin.back}?${Math.random()}`;
            },
            changeCloak() {
                this.cloak.front = `${this.cloak.front}?${Math.random()}`;
                this.cloak.back = `${this.cloak.back}?${Math.random()}`;
            },
            setData(response) {
                const data = response.data;

                this.skin.allowed = data.skin.allowed;
                this.skin.front = data.skin.front;
                this.skin.back = data.skin.back;
                this.skin.default = data.skin.default;
                this.skin.resolutions = data.skin.image_sizes;
                this.skin.fileSize = data.skin.max_file_size;

                this.cloak.allowed = data.cloak.allowed;
                this.cloak.front = data.cloak.front;
                this.cloak.back = data.cloak.back;
                this.cloak.exists = data.cloak.exists;
                this.cloak.resolutions = data.cloak.image_sizes;
                this.cloak.fileSize = data.cloak.max_file_size;
            }
        },
    }
</script>

<style lang="sass" scoped>
    .uploader
        width: 200px
        display: inline-block
</style>
