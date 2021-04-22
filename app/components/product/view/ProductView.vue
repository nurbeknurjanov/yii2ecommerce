<template>
    <fragment>

        <h1 class="title">{{product.title}}</h1>


        <div class="row product-view">
            <product-view-details :product="product"></product-view-details>

            <div class="col-lg-2 col-xs-2 product-right-block">
                <favorite-button :product="product" />
                <compare-button :product="product" />
            </div>
        </div>

        <br/>

        <tabs :product="product"></tabs>
        <br/>
        <br/>
        <br/>
    </fragment>
</template>


<script>

    import {ProductModel} from '../../../api/ProductModel.js'
    import BuyButton from "../BuyButton.vue";
    import ProductViewDetails from "./_view/ProductViewDetails.vue";
    import Tabs from "./_view/Tabs.vue";
    import FavoriteButton from "./_view/FavoriteButton.vue";
    import CompareButton from "./_view/CompareButton.vue";


    export default {
        components: {CompareButton, FavoriteButton, ProductViewDetails, BuyButton,Tabs},
        beforeCreate() {
            if (this.$route.params.id)
                this.id = this.$route.params.id;
            else {
                if (this.$route.query.id)
                    this.id = this.$route.query.id;
            }
            ProductModel.findOne(this.id, 'url,images,mainThumbUrlMd,mainImageUrl,category.parents,values.field')
                .then((result) => {
                this.product = result

                this.$store.commit('setTitle', {
                    menuTitle: this.product.title,
                    title: this.product.title,
                })
                this.setBreadCrumbs()
            })
        },
        data() {
            return {
                id: '',
                product: {},
            };
        },
        methods: {
            setBreadCrumbs() {
                let category = this.product.category;
                var breadCrumbLinks = [];
                breadCrumbLinks = breadCrumbLinks.concat([{label: t['All products'], url: baseUrlWithLanguage+'/products'}])
                //let reversed = category.parents.reverse();
                category.parents.forEach(parentCategory => {
                    breadCrumbLinks = breadCrumbLinks.concat([{label: parentCategory.title, url: parentCategory.url}])
                })
                breadCrumbLinks = breadCrumbLinks.concat([{label: category.title, url: category.url}])
                breadCrumbLinks = breadCrumbLinks.concat([this.product.title])
                this.$store.commit('setBreadCrumbs', breadCrumbLinks)
            },
        },

    }
</script>