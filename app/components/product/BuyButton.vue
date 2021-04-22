<template>

    <a :id="'showBasket-'+product.id" :class="['btn btn-warning showBasket', buttonClass, alreadyInBasket]" href=""
       :data-count="count"
       :data-product_id="product.id"
       :data-price="product.price"
       :data-title="product.title"
       :data-group_id="product.group_id" @click="setLastBuyButton">{{t['Buy']}}</a>

</template>

<script>
    import BasketModel from '../../api/BasketModel.js';

    export default {
        data(){
            return {
                c:1,
                t:t,
            }
        },
        computed:{
            alreadyInBasket(){
                if(BasketModel.isAlreadyInBasket(this.product.id))
                    return 'alreadyInBasket';
                return ''
            },
            count(){
                this.c;
                let orderProduct = BasketModel.getProduct(this.product.id)
                if(orderProduct){
                    return orderProduct.count;
                }
                return 1;
            },
        },
        props: {
            product: {
                type: Object,
            },
            buttonClass: {
                type: String,
                default: 'btn-sm'
            },
        },
        methods:{
            refreshCount(){
                this.c++
            },
            setLastBuyButton(){
                this.$store.state.lastBuyButton = this
            }
        },
    }
</script>