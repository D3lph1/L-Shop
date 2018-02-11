<template>
    <div class="row">
        <div class="col-12" id="skin">
            <img :src="skinFront" alt="skin" id="skin-front">
            <img :src="skinBack" alt="skin" id="skin-back">
        </div>
        <div class="col-12" id="skin-upload">
            <form id="skin-form" enctype="multipart/form-data">
                <label for="upload-skin" class="btn btn-primary pointer" style="display: inline-block;">{{ $t('content.profile.character.select_file') }}<i class="fa fa-download fa-right"></i></label><br/>
                <input class="d-none" type="file" name="skin" id="upload-skin" accept="image/png" @change="onChange">
            </form>
            <input type="text" readonly id="skin-location">
        </div>
        <div class="col-12">
            <button id="profile-update-skin" class="btn green" :disabled="btnDisabled" @click="upload"><i class="fa fa-refresh fa-left"></i>{{ $t('content.profile.character.update') }}</button>
            <div class="alert alert-info mt-3" v-html="$t('content.profile.character.max_file_size', {size: maxSkinSize})"></div>
            <div class="alert alert-info">
                <span v-if="hdSkinEnabled" v-html="$t('content.profile.character.skin.image_size', {list})"></span>
                <span v-else v-html="$t('content.profile.character.skin.max_image_size')"></span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['routeSkinFront', 'routeSkinBack', 'routeUpdate', 'maxSkinSize', 'availableImageSizes', 'hdSkinEnabled'],
        data() {
            return {
                btnDisabled: true,
                skinFront: this.routeSkinFront,
                skinBack: this.routeSkinBack,
                location: '',
                files: []
            }
        },
        computed: {
            list() {
                let result = [];
                for (let i = 0; i < this.availableImageSizes.length; i++) {
                    result.push(`${this.availableImageSizes[i][0]}x${this.availableImageSizes[i][1]}`);
                }

                return result.join(', ');
            }
        },
        methods: {
            onChange(event) {
                this.location = event.target.value;
                this.btnDisabled = this.location === '';
                this.files = event.target.files;
            },
            upload() {
                if (this.files.length === 0) {
                    return;
                }
                let data = new FormData();
                data.append('skin', this.files[0]);
                axios.post(this.routeUpdate, data, {headers: { 'content-type': 'multipart/form-data' }})
                    .then((response) => {
                        if (response.data.status === 'success') {
                            this.skinFront = `${this.routeSkinFront}?${Math.random()}`;
                            this.skinBack = `${this.routeSkinBack}?${Math.random()}`;
                        }
                    });
            }
        }
    }
</script>
