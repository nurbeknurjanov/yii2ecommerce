<template>
    <div id="orderProductsGrid" class="grid-view">
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>{{t['Product']}}</th>
                <th>{{t['Count']}}</th>
                <th>{{t['Price']}}</th>
                <th>{{t['Amount']}}</th>
                <th class="action-column">&nbsp;</th>
            </tr>
            </thead>

            <tbody>
            <tr v-for="(orderProduct, key, index) in orderProducts" :product="product = products[orderProduct.product_id]" :data-key="key" >
                <td>{{index+1}}</td>
                <td>
                    <router-link :to="product.url"  >
                        {{product.title}}
                    </router-link>
                </td>
                <td class="countTD">
                    <div :class="['form-group required', 'field-orderproduct-'+key+'-count', errors[product.id] ? 'has-error':'has-success']">
                        <input type="text"
                               :id="'orderproduct-'+key+'-count'"
                               class="count form-control"
                               :name="'OrderProduct['+key+'][count]'"
                               style="max-width:80px"
                               v-model="inputCounts[key]"
                        >
                        <div class="help-block">{{errors[product.id]}}</div>
                    </div>
                </td>
                <td class="priceTD" :data-price="orderProduct.price" data-currency="$">{{product.priceCurrency}}</td>
                <td class="amountTD" :data-amount="orderProduct.price * orderProduct.count">{{orderProduct.price * orderProduct.count}}</td>
                <td>
                    <a href="" title="Delete" aria-label="Delete"
                       @click="removeFromBasket(product.id)"
                    >
                        <span class="glyphicon glyphicon-trash"></span>
                    </a>
                </td>
            </tr>
            </tbody>

            <tfoot>
            <tr style="font-weight:bold;text-decoration: underline;">
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td class="totalAmountTD">{{amount}}</td>
                <td>&nbsp;</td>
            </tr>
            </tfoot>
        </table>
    </div>
</template>

<script>
    let product=null;
    import BasketModel from '../../api/BasketModel.js'
    import {ProductModel} from '../../api/ProductModel.js'

    export default {
        props: ['orderProducts','products','amount','inputCounts','errors'],
        data() {
            return {
                t:t,
            }
        },
        methods:{

            async removeFromBasket(product_id){
                bootbox.confirm(this.t['Are you sure you want to remove this item from shopping cart ?'], (result)=>{
                    if (result) {
                        BasketModel.delete(product_id);
                        this.$store.commit('updateBasketButtonText');
                        this.$store.commit('notify', {type:'success', message:t['You removed the item from shopping cart.']});
                        this.$parent.initList()//nurbek
                    }
                });
            },

        }
    }
</script>