<template>
    <v-list class="pt-0 pb-0" subheader>
        <v-subheader>{{ $t('content.layout.shop.sidebar.balance.title') }}</v-subheader>
        <v-list-tile ripple>
            <v-list-tile-action>
                <v-icon>money</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
                <v-list-tile-title>{{ $store.state.auth.user.balance }} <span v-html="$store.state.shop.currency.html"></span></v-list-tile-title>
            </v-list-tile-content>
        </v-list-tile>
        <v-list-tile ripple :to="{name: 'frontend.shop.replenishment'}">
            <v-list-tile-action>
                <v-icon>add_circle_outline</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
                <v-list-tile-title>{{ $t('content.layout.shop.sidebar.balance.replenishment') }}</v-list-tile-title>
            </v-list-tile-content>
        </v-list-tile>
    </v-list>
</template>
