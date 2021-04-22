<template>
    <fragment>

        <h1 class="title">{{pageTitle}}</h1>


        <div class="alert-warning alert fade in" v-if="exists">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{emptyCompare}}
        </div>

        <div style="width: 100%; overflow: scroll">
            <table class="table table-striped compareTable">
                <thead>
                <tr>
                    <th></th>
                    <th v-for="product in products" :data-key="product.id" >
                        <products-list-tab-element :product="product"></products-list-tab-element>
                        <a href=""
                           @click.self.prevent="removeFromCompare(product.id)"
                           class="compare-remove"  >
                            <i class="glyphicon glyphicon-remove"></i>
                            {{remove}}
                        </a>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="field in fields" :data-key="field.id">
                    <td>
                        {{field.label}}
                    </td>
                    <td v-for="product in products" :data-key="product.id" v-html="getValueFromProduct(product, field)">
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="clear"></div>


    </fragment>
</template>

<script>

    import ProductsListTabElement from './_list/ProductsListTabElement.vue';
    import {ProductModel} from '../../../api/ProductModel.js'
    import CompareModel from '../../../api/CompareModel.js'


    export default {
        components:{ProductsListTabElement},
        computed:{
            exists(){
                return this.products.length===0;
            }
        },
        created() {
            this.refreshCompareProducts();
        },
        data() {
            return {
                fields: [],
                products: [],
                pageTitle: null,
                remove: t['Remove'],
                emptyCompare: t['You didn\'t select the items to compare.'],
            };
        },

        methods: {
            removeFromCompare(id){
                bootbox.confirm(t['Do you want to remove the item from compare ?'], (result)=>{
                    if (result) {
                        CompareModel.delete(id);
                        this.refreshCompareProducts()
                        CompareModel.nProducts().then(nProductsText=>{
                            $('#compareCountSpan').html(nProductsText)
                        })
                    }
                });
            },
            getValueFromProduct(product, field){
                for(var key in product.values){
                    let value = product.values[key];
                    if(value.field_id==field.id)
                        return value.valueText;
                }
                return '<span class="not-set">(not set)</span>'
            },
            async refreshCompareProducts() {
                let data = await ProductModel.findAllCompare()

                this.pageTitle = data.pageTitle;

                this.$store.commit('setTitle', {
                    menuTitle: data.menuTitle,
                    topTitle: data.topTitle,
                    title: data.title,
                })

                this.setBreadCrumbs(data);

                this.products = data.products;

                this.fields = data.fields;
            },
            setBreadCrumbs(data) {
                let breadCrumbLinks = [];
                breadCrumbLinks = breadCrumbLinks.concat([data.breadCrumbTitle])
                this.$store.commit('setBreadCrumbs', breadCrumbLinks)
            },
        },
    }
</script>