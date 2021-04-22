<template>

    <div class="col-lg-3 col-sm-3 col-xs-4 list-block">
        <div>
            <router-link :to="product.url" :class="product.typeClass"  :data-discount="product.discount" >
                <img :src="product.mainThumbUrl" :alt="product.title">
            </router-link>

            <div class="title">
                <router-link :to="product.url" class="title" >
                    {{ product.title }}
                </router-link>
            </div>
            <div>{{product.priceCurrency}}</div>
            <div></div>
            <div>
                <input type="text"
                       class="product-rating-class rating-loading"
                       :id="'product-rating-'+product.id"
                       :name="'product-rating-'+product.id"
                       data-krajee-rating="ratingOptions"
                       :value="product.rating"
                >
            </div>
            <buy-button :product="product"></buy-button>
        </div>
    </div>


</template>

<script>
    import BuyButton from '../../BuyButton.vue'

    export default {
        components: {BuyButton},
        props: ['product'],
        mounted() {
            this.$nextTick(function () {
                if ($('#product-rating-' + this.product.id).data('rating'))
                    $('#product-rating-' + this.product.id).rating('destroy');
                $('#product-rating-' + this.product.id).rating(ratingOptions);
            })
        }
    }
</script>