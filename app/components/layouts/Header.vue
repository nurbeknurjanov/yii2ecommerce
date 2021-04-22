<template>

    <div id="headerContent" ></div>

</template>

<script>


    import BasketButton from '../order/BasketButton.vue'
    import axios from 'axios';
    import Vue from 'vue'
    import FavoriteModel from '../../api/FavoriteModel.js'
    import CompareModel from '../../api/CompareModel.js'

    export default {
        watch: {
            '$route.fullPath': {
                handler: function (fullPath) {

                    $('#q').val(this.$route.query.q)

                },
                immediate: true
            },
        },
        beforeCreate() {
            axios
                .get(apiUrlWithLanguage+'/site/header', {
                    withCredentials: true,
                    params:{
                        q:this.$route.query.q
                    }
                })
                .then(async response => {
                    $('#headerContent').replaceWith(response.data['data']);//becase scripts needs to work

                    $('#compareCountSpan').html(await CompareModel.nProducts())
                    $('#favoriteCountSpan').html(await FavoriteModel.nProducts())


                    //component for topTitle
                    new Vue({
                        store: this.$store,
                        computed:{
                            topTitle(){
                                return this.$store.state.topTitle
                            },
                        },
                        template:'<span class="navbar-brand" >{{topTitle}}</span>'
                    }).$mount('.navbar-menu-top-hidden .navbar-brand');


                    //component for menuTitle
                    new Vue({
                        store: this.$store,
                        computed:{
                            menuTitle(){
                                return this.$store.state.menuTitle
                            },
                        },
                        template:'<span class="navbar-brand" >{{menuTitle}}</span>'
                    }).$mount('.navbar-menu-hidden .navbar-brand');

                    //component for basket button
                    new Vue({
                        el: '.basket-block',
                        store:this.$store,
                        render: function(h){
                            return h(BasketButton)
                        },
                    })

                });

        },
        mounted(){
            $('body').off('click', '.addToFavorite');
            $('body').off('click', '.removeFromFavorite');

            $('body').off('click', '.addToCompare');
            $('body').off('click', '.removeFromCompare');
        }
    }
</script>
