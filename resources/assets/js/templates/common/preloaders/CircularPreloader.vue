<template>
    <div class="text-xs-center">
        <transition name="fade-transition">
            <v-progress-circular
                    id="preloader"
                    color="secondary"
                    indeterminate
                    v-if="this.$store.state.loading"
            ></v-progress-circular>
        </transition>
    </div>
</template>

<style lang="sass" scoped>
    #preloader
        position: fixed
        top: 0
        margin-top: 10px
        z-index: 10000
</style>
