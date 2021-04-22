<template>
    <!--<div v-html="htmlData"></div>//scripts are dying-->
    <div id="eavHtmlData"></div>
</template>

<script>

    import {ProductModel} from '../../api/ProductModel.js'

    export default {
        data(){
            return {
                htmlData:''
            }
        },
        beforeDestroy(){
            this.htmlData=''
        },
        watch: {
            htmlData: {
                handler: function (newValue) {
                    $('#eavHtmlData').html(newValue)
                },
            },
        },
        methods:{
            refreshData(){
                this.htmlData = ProductModel.eavData
            }
        },
    }
</script>