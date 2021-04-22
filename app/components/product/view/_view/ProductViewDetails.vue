<template>
    <fragment>
        <div class="col-lg-6 col-xs-6 ">
            <div :class="['product-image', product.typeClass]"
                 :data-discount="product.discount">
                <img class="zoom-container"
                     :src="product.mainThumbUrlMd"
                     :alt="product.title"
                     :data-large="product.mainImageUrl"
                     v-if="product.mainImageUrl"
                     v-on:load="initZoom"
                >
                <img src="https://placehold.it/400x400" :alt="product.title" v-if="!product" >
            </div>

            <div class="product-images-wrap">
                <div class="scrollLeft scrollHide"><i class="glyphicon glyphicon-menu-left"></i></div>
                <div class="product-images">
                    <div class="table-row">
                        <div v-for="image in product.images" class="table-cell">
                            <div class="product-thumbnail">
                                <a :href="image.imageUrl" data-lightbox="roadtrip">
                                    <img class="zoom-image"
                                         :src="image.thumbUrlXs"
                                         :alt="image.title"
                                         :data-medium="image.thumbUrlMd"
                                         :data-large="image.imageUrl">
                                </a>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="scrollRight"><i class="glyphicon glyphicon-menu-right"></i></div>
            </div>

        </div>
        <div class="col-lg-4 col-xs-4">
            <div v-if="product.sku"><label>SKU:</label> {{product.sku}}</div>
            <div><span class="price">{{product.priceCurrency}}</span></div>
            <div><label>Status:</label> {{product.statusText}}</div>


            <div class="product-view-rating">
                <input type="text"
                       class="rating-loading"
                       :id="'product-rating-'+product.id"
                       :name="'product-rating-'+product.id"
                       data-krajee-rating="ratingOptions"
                       :value="product.rating"
                       v-on:loadeddata="initRating"
                >
            </div>
            <div v-if="product.discount"><label>Discount:</label> {{product.discount}}%</div>

            <buy-button :product="product" button-class="btn-lg"></buy-button>
        </div>
    </fragment>
</template>


<script>

    import BuyButton from "../../BuyButton.vue";


    export default {
        props: ['product'],
        components: {BuyButton},
        methods:{
            initZoom(){
                $(".zoom-container").imagezoomsl({
                    zoomrange: [1, 10],
                    magnifiersize: ['40%', '70%'],
                    //magnifiersize: [557, 377],
                    magnifierborder: '1px solid #888',
                })
            },
            initRating(){
                if ($('#product-rating-' + this.product.id).data('rating'))
                    $('#product-rating-' + this.product.id).rating('destroy');
                $('#product-rating-' + this.product.id).rating(ratingOptions);
            }
        },
        updated(){
            this.initZoom()
            this.initRating()
        },
        mounted() {

            //this.someData = 'is changed'
            this.$nextTick(function () {
            })


            this.initRating()

        },
    }
</script>