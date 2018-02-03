<template>
    <div class="product-block z-depth-1">
        <p class="product-name full-w">{{ name }}</p>

        <img :src="image" :alt="name" class="product-image image-fluid">

        <p class="product-price"><span class="catalog-price-span">{{ price }}</span> <span v-html="currency"></span></p>
        <p class="product-count">
            <span v-if="!(isPermgroup && stack === 0)">{{ $t('content.shop.catalog.item.for') }}</span>
            <span v-if="isItem" class="number">{{ stack }}</span>
            <span v-else-if="isPermgroup">
                <span v-if="stack === 0">{{ $t('content.shop.catalog.item.forever') }}</span>
                <span v-else>{{ stack }}</span>
            </span>

            <span v-if="isItem">{{ $t('content.shop.catalog.item.items') }}</span>
            <span v-else-if="isPermgroup">
                <span v-if="stack !== 0">{{ $t('content.shop.catalog.item.duration') }}</span>
            </span>
        </p>

        <button class="btn btn-info btn-block btn-sm" :disabled="cartBtnDisabled" @click="put">
            <i class="fa fa-cart-arrow-down fa-left"></i>
            <span v-if="alreadyInCart">
                {{ $t('content.shop.catalog.item.already_in_cart') }}
            </span>
            <span v-else>
                {{ $t('content.shop.catalog.item.put_in_cart') }}
            </span>
        </button>

        <button class="btn btn-warning btn-block btn-sm" @click="quickPurchaseModal">
            <i class="fa fa-money fa-left"></i>
            {{ $t('content.shop.catalog.item.fast_buy') }}
        </button>
    </div>

</template>

<script>
    export default {
        props: ['productId', 'name', 'image', 'price', 'currency', 'stack', 'isItem', 'isPermgroup', 'inCart',
            'putInCartRoute', 'quickPurchaseRoute'],
        data() {
            return {
                cartBtnDisabled: this.inCart,
                alreadyInCart: this.inCart
            }
        },
        methods: {
            put() {
                this.cartBtnDisabled = true;
                axios.post(this.putInCartRoute, {
                    _method: 'PUT',
                    product: this.productId
                })
                    .then((response) => {
                        if (response.data.status === 'success') {
                            this.alreadyInCart = true;
                            this.$store.commit('putInCart', 1);
                        } else {
                            this.cartBtnDisabled = false;
                        }
                    });
            },
            quickPurchaseModal() {
                this.$store.commit('quickPurchase', {name: this.name, price: this.price, stack: this.stack, url: this.quickPurchaseRoute});
                $('#catalog-to-buy-modal').modal({show : true});
            }
        }
    }
</script>
