<template>
    <div>
        <v-text-field prepend-icon="attach_file"
                      single-line
                      v-model="filename"
                      :label="label"
                      :required="required"
                      @click.native="onFocus"
                      :disabled="disabled" ref="fileTextField"></v-text-field>
        <input
                type="file"
                :accept="accept"
                :multiple="false"
                :disabled="disabled"
                ref="fileInput"
                @change="onFileChange"
        >
    </div>
</template>

<script>
    export default{
        props: {
            value: {
                type: [Array, String]
            },
            accept: {
                type: String,
                default: "*"
            },
            label: {
                type: String,
                default: $t('common.choose_file')
            },
            required: {
                type: Boolean,
                default: false
            },
            disabled: {
                type: Boolean,
                default: false
            },
            multiple: {
                type: Boolean,
                default: false
            },
            reset: {
                type: Boolean,
                default: false
            }
        },
        data(){
            return {
                filename: ''
            };
        },
        watch: {
            value(val){
                this.filename = val;
            },
            reset(val) {
                if (val) {
                    this.filename = '';
                    this.$refs.fileInput.type = '';
                    this.$refs.fileInput.type = 'file';
                }
            }
        },
        mounted() {
            this.filename = this.value;
        },

        methods: {
            getFormData(files) {
                const data = new FormData();
                [...files].forEach(file => {
                    data.append('file', file, file.name);
                });

                return data;
            },
            onFocus(){
                if (!this.disabled) {
                    debugger;
                    this.$refs.fileInput.click();
                }
            },
            onFileChange($event){
                const files = $event.target.files || $event.dataTransfer.files;
                const form = this.getFormData(files);
                if (files) {
                    if (files.length > 0) {
                        this.filename = [...files].map(file => file.name).join(', ');
                    } else {
                        this.filename = null;
                    }
                } else {
                    this.filename = $event.target.value.split('\\').pop();
                }

                let previews = [];
                if (this.multiple) {
                    for (let i = 0; i < $event.target.files.length; i++) {
                        previews.push(URL.createObjectURL($event.target.files[i]));
                    }
                } else {
                    if ($event.target.files[0]) {
                        previews = URL.createObjectURL($event.target.files[0]);
                    }
                }

                this.$emit('input', this.filename);
                this.$emit('formData', form);
                this.$emit('preview', previews)
            }
        }
    };
</script>

<style lang="sass" scoped>
    input[type=file]
        position: absolute
        left: -99999px
</style>
