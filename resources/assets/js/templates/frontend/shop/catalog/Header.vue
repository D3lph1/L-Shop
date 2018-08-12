<template>
    <div id="logo-block">
        <div class="logo-img">
            <img :src="logo" alt="logo" class="c-logo">
        </div>
        <div class="logo-text">
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

