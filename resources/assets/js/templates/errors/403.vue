<template>
    <v-container
            id="full"
            fluid
            align-center
            justify-center
    >
        <v-card
                id="enter-card"
                width="300px"
        >
            <v-card
                    id="form-header"
                    color="primary"
            >
                <v-icon medium color="white">pan_tool</v-icon>
                <h1>403</h1>
            </v-card>

            <v-card-text class="subheading">
                {{ $t('content.errors.403.description') }}
            </v-card-text>

            <v-footer
                    height="auto"
                    id="form-footer"
            >
                <v-tooltip bottom>
                    <v-btn
                            large
                            outline
                            icon
                            color="secondary"
                            slot="activator"
                            :to="{name: 'frontend.index'}"
                    >
                        <v-icon>arrow_back</v-icon>
                    </v-btn>
                    <span>{{ $t('common.back_to_main') }}</span>
                </v-tooltip>
            </v-footer>
        </v-card>
    </v-container>
</template>

<script>
    export default {
        //
    }
</script>
