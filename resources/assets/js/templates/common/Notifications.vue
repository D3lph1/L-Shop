<template>
    <div class="notifications">
        <transition-group name="slide-x-transition" tag="div">
            <v-alert
                    v-for="(item, index) in notifications"
                    class="notification"
                    :type="item.type"
                    :key="index"
                    :value="true"
                    v-html="item.content"
            ></v-alert>
        </transition-group>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                m: true
            }
        },
        computed: {
            notifications() {
                return this.$store.state.notifications;
            }
        }
    }
</script>

<style lang="sass" scoped>
    .notifications
        position: fixed
        top: 1rem
        right: 1rem
        z-index: 10000
        .notification
            position: relative
            padding: .5rem 1.5rem .5rem 1rem
            max-width: 320px
            margin-bottom: .5rem
</style>
