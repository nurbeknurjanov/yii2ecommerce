<template>
    <div class="basket-block">
        <slot name="default">
            <div>{{t['In Shopping cart']}}</div>
            <a :href="url" :class="['btn btn-default', {basketActive:isBasketActive}]">
                <i class="glyphicon glyphicon-shopping-cart"></i>
                <span id="basketCountSpan">{{messageBasket}}</span> </a>
        </slot>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                url:baseUrlWithLanguage+'/order/order/create1',
                t:t,
            }
        },
        computed: {
            messageBasket(){
                return this.$store.state.basket.text
            },
            isBasketActive(){
                return this.$store.state.basket.count>0
            }
        },
        mounted() {
            this.$store.commit('updateBasketButtonText')
        },
    }
</script>