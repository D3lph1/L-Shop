<template>
    <div class="row">
        <div class="col-12" id="cloak">
            <div v-if="showCloak">
                <img :src="cloakFront" alt="cloak-front">
                <img :src="cloakBack" alt="cloak-back">
            </div>
            <div v-else class="alert alert-info">
                {{ $t('content.profile.character.cloak.not_set') }}
            </div>
        </div>
        <div class="col-12" id="cloak-upload">
            <form id="cloak-form" enctype="multipart/form-data">
                <label for="upload-cloak" class="btn btn-primary pointer" style="display: inline-block;">{{ $t('content.profile.character.select_file') }}<i class="fa fa-download fa-right"></i></label><br/>
                <input class="d-none" type="file" name="cloak" id="upload-cloak" accept="image/png" @change="onChange">
            </form>
            <input type="text" v-model="location" readonly id="cloak-location">
        </div>
        <div class="col-12">
            <button class="btn green" :disabled="btnDisabled" @click="upload"><i class="fa fa-refresh fa-left"></i>{{ $t('content.profile.character.update') }}</button>
            <div class="alert alert-info mt-3" v-html="$t('content.profile.character.max_file_size', {size: maxCloakSize})"></div>
            <div class="alert alert-info">
                <span v-if="hdCloakEnabled" v-html="$t('content.profile.character.cloak.image_size', {list})"></span>
                <span v-else v-html="$t('content.profile.character.cloak.max_image_size')"></span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['cloakExist', 'routeCloakFront', 'routeCloakBack', 'routeUpdate', 'availableImageSizes', 'maxCloakSize', 'hdCloakEnabled'],
        data() {
            return {
                showCloak: this.cloakExist,
                btnDisabled: true,
                cloakFront: this.routeCloakFront,
                cloakBack: this.routeCloakBack,
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
                data.append('cloak', this.files[0]);
                axios.post(this.routeUpdate, data, {headers: { 'content-type': 'multipart/form-data' }})
                    .then((response) => {
                        if (response.data.status === 'success') {
                            this.showCloak = true;
                            this.cloakFront = `${this.routeCloakFront}?${Math.random()}`;
                            this.cloakBack = `${this.routeCloakBack}?${Math.random()}`;
                        }
                    });
            }
        }
    }
</script>
