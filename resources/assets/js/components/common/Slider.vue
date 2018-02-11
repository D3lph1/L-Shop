<template>
    <div>
        <div class="slider-container" ref="container" :style="style">
            <slot></slot>
        </div>
    </div>
</template>

<style>
    .slider-container {
        overflow: hidden;
        transition-property: all;
    }
</style>

<script>
    export default {
        props: {
            opened: Boolean,
            duration: {
                type: Number,
                default: 500
            }
        },
        data: () => ({
            maxHeight: 0
        }),
        watch: {
            opened (opened) {
                const { container } = this.$refs;
                if (opened) {
                    const style = container.getAttribute('style');
                    container.removeAttribute('style');
                    this.maxHeight = container.offsetHeight;
                    container.setAttribute('style', style);

                    container.offsetHeight
                } else {
                    this.maxHeight = 0
                }
            }
        },
        computed: {
            style () {
                return {
                    height: this.maxHeight + 'px',
                    'transition-duration': this.duration + 'ms'
                }
            }
        }
    }
</script>
