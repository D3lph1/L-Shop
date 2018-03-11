<template>
    <transition name="fade-transition">
        <v-progress-linear
                id="preloader"
                height="3"
                color="secondary"
                indeterminate
                v-if="this.$store.state.loading"
        ></v-progress-linear>
    </transition>
</template>

<style lang="sass" scoped>
    #preloader
        position: fixed
        top: 0
        margin-top: 0
        z-index: 10000
</style>
