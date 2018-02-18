<template>
    <div id="logo-block">
        <div class="logo-img">
            <img :src="logo" alt="logo" class="c-logo">
        </div>
        <div class="logo-text text-depth">
            <h1 class="display-3 grey--text text--darken-3">{{ shopName }}</h1>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            shopName: {
                required: true
            },
            logo: {
                required: true
            }
        }
    }
</script>

<style lang="sass" scoped>
    #logo-block
        padding: 1rem
        display: -webkit-flex
        display: -ms-flex
        display: flex
        margin-bottom: 1rem
        justify-content: center
        flex-wrap: wrap
        .c-logo
            max-width: 200px
            margin: 0 1rem
        .logo-text
            justify-content: center
            align-self: center
            margin: 0 1rem
</style>
