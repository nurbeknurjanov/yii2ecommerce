<template>
    <a :class="['compare', compareClass]"
       @click.self.prevent="switchCompare"
       href=""
       :title="compareTitle"></a>
</template>


<script>

    import CompareModel from '../../../../api/CompareModel.js'

    export default {
        props: ['product'],
        data(){
            return {
                refreshComputed:0
            }
        },
        computed:{
            compareClass(){
                this.refreshComputed;
                return CompareModel.isAlreadyInCompare(this.product.id) ? 'removeFromCompare':'addToCompare'
            },
            compareTitle(){
                this.refreshComputed;
                return CompareModel.isAlreadyInCompare(this.product.id) ? removeCompareTitle:addCompareTitle
            }
        },
        methods: {
            switchCompare(){

                let id = this.product.id
                if(CompareModel.isAlreadyInCompare(id)){
                    CompareModel.delete(id);
                    this.$store.commit('notify', {type:'success', message:t['You successfully removed the item from compare.']});
                }
                else{
                    CompareModel.add(id)
                    this.$store.commit('notify', {type:'success', message:t['You successfully added the item into compare.']});
                }
                this.refreshComputed++
                CompareModel.nProducts().then(nProductsText=>{
                    $('#compareCountSpan').html(nProductsText)
                })
            }
        },
    }
</script>