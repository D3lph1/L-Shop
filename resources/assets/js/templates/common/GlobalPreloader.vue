<template>
    <transition name="fade-out">
        <div v-if="this.$store.state.loading" id="pre-loader">
            <v-progress-circular indeterminate :size="80" color="primary"></v-progress-circular>
        </div>
    </transition>
</template>

<style lang="sass" scoped>
    #pre-loader
        position: fixed
        top: 0
        left: 0
        display: -webkit-flex
        display: -ms-flex
        display: flex
        width: 100vw
        height: 100vh
        background-color: #fff
        z-index: 101
        justify-content: center
        align-items: center
        #pre-animation
            span
                font-size: 10rem
</style>
