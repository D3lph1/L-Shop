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
                <v-icon medium color="white">access_time</v-icon>
                <h1>500</h1>
            </v-card>

            <v-card-text class="subheading">
                {{ $t('content.errors.500.description') }}
            </v-card-text>

            <v-footer
                    height="auto"
                    id="form-footer"
            >
            </v-footer>
        </v-card>
    </v-container>
</template>

<script>
    export default {
        //
    }
</script>
