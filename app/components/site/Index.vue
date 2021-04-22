<template>
    <div id="indexContent">
    </div>
</template>


<script>
    import axios from 'axios';
    import BuyButton from '../product/BuyButton.vue'
    import Vue from 'vue'

    export default {
        data () {
            return {
                indexContent: null,
            };
        },
        mounted() {
            this.$store.commit('setTitle', {});
            this.$store.commit('setBreadCrumbs', [])
            axios
                .get(apiUrlWithLanguage+'/site/index')
                .then(response => {
                    var indexContent = response.data['data'].content;
                    indexContent = str_replace('javascript:void(0);', '', indexContent)
                    indexContent = str_replace('javascript:void(0)', '', indexContent)
                    $('#indexContent').html(indexContent)



                    let popular = response.data['data'].populars
                    popular.forEach(product=>{
                        new Vue({
                            el:  '.populars #showBasket-'+product.id,
                            store:this.$store,
                            render: function(h){
                                return h(BuyButton,{
                                    props: {
                                        product: product
                                    }
                                })
                            },
                        })
                    })

                    let novelties = response.data['data'].novelties
                    novelties.forEach(product=>{
                        new Vue({
                            el:  '.novelties #showBasket-'+product.id,
                            store:this.$store,
                            render: function(h){
                                return h(BuyButton,{
                                    props: {
                                        product: product
                                    }
                                })
                            },
                        })
                    })

                });
        }
    }
</script>