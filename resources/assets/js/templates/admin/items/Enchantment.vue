<template>
    <v-layout row justify-center>
        <v-dialog v-model="dialogData" max-width="600px">
            <v-card>
                <v-card-title>
                    <span class="headline">{{ $t('content.admin.items.add.enchantment.title') }}</span>
                </v-card-title>
                <v-card-text>
                    <v-container grid-list-md>
                        <v-alert type="info" outline :value="true">{{ $t('content.admin.items.add.enchantment.description') }}</v-alert>

                        <div class="mt-3">
                            <div v-for="(enchantment, index) in models">
                                <v-subheader inset v-if="(index - 1 >= 0 && models[index - 1].group !== enchantment.group) || index === 0">{{ enchantment.groupName }}</v-subheader>
                                <v-slider
                                        :label="enchantment.name"
                                        v-model="enchantment.model"
                                        :max="enchantment.maxLevel"
                                        thumb-label
                                        color="purple"
                                        :disabled="enchantment.disabled"
                                        @input="sliderChanged"
                                        ticks
                                ></v-slider>
                            </div>
                        </div>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="purple" flat @click.native="dialogData = false">{{ $t('common.close') }}</v-btn>
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
            enchantments: {
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
            enchantments(val) {
                val.forEach(enchantment => {
                    if (typeof enchantment.model === 'undefined') {
                        enchantment.model = 0;
                    }
                    enchantment.disabled = false;
                    this.models.push(enchantment);
                });
                this.updateSliders();
            }
        },
        methods: {
            sliderChanged() {
                this.dialogData = false;
                this.dialogData = true;

                this.updateSliders();
            },
            updateSliders() {
                // Disable enchantments from other group. If the group is null, it means that the group
                // is common and no blocking occurs.

                let group = null;
                this.models.forEach(enchantment => {
                    if (group === null) {
                        if (enchantment.model > 0) {
                            group = enchantment.group;
                        }
                    }
                });

                if (group === null) {
                    this.models.forEach(enchantment => {
                        enchantment.disabled = false;
                    });
                } else {
                    this.models.forEach(enchantment => {
                        if (enchantment.group !== group && enchantment.group !== null) {
                            enchantment.disabled = true;
                        }
                    });
                }
            }
        }
    }
</script>
