<template>
    <div>
        <v-toolbar flat>
            <v-toolbar-title id="drawer-username">
                <v-icon>person_outline</v-icon>
                <span>{{ $store.state.auth.user.username }}</span>
            </v-toolbar-title>
        </v-toolbar>

        <v-divider></v-divider>
    </div>
</template>

<style lang="less" scoped>
    #drawer-username {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        margin: 0;
        span {
            margin-left: 10px;
        }
    }
</style>
