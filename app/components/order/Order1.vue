<template>
    <div>

        <h1 class="title" v-html="title"></h1>

        <form v-if="Object.keys(orderProducts).length>0" class="form-horizontal" :action="url" method="post" v-on:submit.prevent="submitForm">

            <order-products
                    :order-products="orderProducts"
                    :products="products"
                    :amount="amount"
                    :inputCounts="inputCounts"
                    :errors="errors"
            />

            <div class="form-group">
                <div class="col-lg-12">
                    <button type="submit" class="btn btn-success btn-lg">
                        {{t['Issue the order']}}
                        <i class='glyphicon glyphicon-chevron-right'></i>
                    </button>
                </div>
            </div>
        </form>

        <div v-else class="alert-warning alert fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{t['Your shopping cart is empty.']}}
        </div>

    </div>
</template>

<script>
    import BasketModel from '../../api/BasketModel.js'
    import {ProductModel} from '../../api/ProductModel.js'
    import OrderProducts from './OrderProducts.vue'


    export default {
        data() {
            return {
                title: t['Shopping cart'],
                t:t,
                url:baseUrlWithLanguage+'/order/order/create2',

                orderProducts:[],
                products:[],
                amount:0,
                inputCounts:[],
            }
        },
        computed:{
            errors(){
                let err = [];
                this.inputCounts.forEach((count, key)=>{
                    switch (true) {
                        case count==='':{ err[key]=t['{attribute} cannot be blank.'].replace(/{attribute}/, t['Count']); break; }
                        case !this.isNumeric(count):{ err[key]=t['{attribute} must be a number.'].replace(/{attribute}/, t['Count']); break; }
                        case count<1:{
                            err[key]=t['{attribute} must be no less than {min}.'].replace(/{attribute}/, t['Count']);
                            err[key] = err[key].replace(/{min}/, 1);
                            break;
                        }
                    }
                })
                return err;
            }
        },
        async created(){
            this.initList()
        },
        methods:{
            isNumeric(n) {
                return !isNaN(parseFloat(n)) && isFinite(n);
            },
            async initList(){
                let ids = Object.keys(BasketModel.findAll());
                this.products = await ProductModel.findAllById(ids)
                this.orderProducts = BasketModel.findAll();
                Object.values(this.orderProducts).forEach(orderProduct=>{
                    this.inputCounts[orderProduct.product_id] = orderProduct.count;
                    this.amount+= (orderProduct.count * orderProduct.price);
                })
            },
            submitForm(){
                if(Object.keys(this.errors).length===0){

                    this.inputCounts.forEach((value, key)=>{
                        BasketModel.add({
                            product_id:key,
                            price:this.products[key].price,
                            count:value,
                        })
                    })

                    this.$router.push(this.url);
                }
            },
        },
        components: {
            OrderProducts
        },
        mounted() {
            this.$store.commit('setTitle', {topTitle: this.title});

            this.$store.commit('setBreadCrumbs', [
                this.title
            ])
        },
    }
</script>