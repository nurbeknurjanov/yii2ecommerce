<template>
    <a href=""
       @click.self.prevent="switchFavorite"
       :class="['favorite', favoriteClass]"
       :title="favoriteTitle"
    ></a>
</template>


<script>

    import FavoriteModel from '../../../../api/FavoriteModel.js'

    export default {
        props: ['product'],
        data(){
            return {
                refreshComputed:0
            }
        },
        computed:{
            favoriteClass(){
                this.refreshComputed;
                return FavoriteModel.isAlreadyInFavorite(this.product.id) ? 'removeFromFavorite':'addToFavorite'
            },
            favoriteTitle(){
                this.refreshComputed;
                return FavoriteModel.isAlreadyInFavorite(this.product.id) ? removeFavoriteTitle:addFavoriteTitle
            },
        },
        methods: {
            switchFavorite(){

                let id = this.product.id
                if(FavoriteModel.isAlreadyInFavorite(id)){
                    FavoriteModel.delete(id);
                    this.$store.commit('notify', {type:'success', message:t['You successfully removed the item from favorites.']});
                }
                else{
                    FavoriteModel.add(id)
                    this.$store.commit('notify', {type:'success', message:t['You successfully added the item into favorites.']});
                }
                this.refreshComputed++
                FavoriteModel.nProducts().then(nProductsText=>{
                    $('#favoriteCountSpan').html(nProductsText)
                })
            },
        },
    }
</script>