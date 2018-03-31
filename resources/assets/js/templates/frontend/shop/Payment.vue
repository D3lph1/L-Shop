<template>
    <div>
        <v-layout>
            <v-flex xs12 class="text-xs-center">
                <p class="headline">{{ $t('content.frontend.shop.payment.title_content') }}</p>
            </v-flex>
        </v-layout>
        <v-layout>
            <v-flex xs12 class="text-xs-center">
                <v-btn color="blue" dark :href="robokassa" v-if="robokassa !== null">Robokassa</v-btn>
                <v-btn color="green" dark :href="interkassa" v-if="interkassa !== null">Interkassa</v-btn>
                <v-alert type="warning" :value="true" v-if="robokassa === null && interkassa === null">
                    {{ $t('content.frontend.shop.payment.methods_not_available') }}
                </v-alert>
            </v-flex>
        </v-layout>
    </div>
</template>

<script>
    import loader from './../../../core/http/loader'

    export default {
        data() {
            return {
                robokassa: null,
                interkassa: null,
            }
        },
        beforeRouteEnter(to, from, next) {
            loader.beforeRouteEnter(`/api/payment/${to.params.purchase}`, to, from, next);
        },
        beforeRouteUpdate(to, from, next) {
            loader.beforeRouteUpdate(`/api/payment/${to.params.purchase}`, to, from, next, this);
        },
        methods: {
            setData(response) {
                const data = response.data;

                this.robokassa = data.robokassaUrl;
                this.interkassa = data.interkassaUrl;
            }
        }
    }
</script>
