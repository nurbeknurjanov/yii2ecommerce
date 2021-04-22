<template id="qwe">
    <span>


        test3
        <br/>



            <!--<script type="text/x-template" id="button-counter-template">
        <button v-on:click="count++">Счётчик кликов = {{ count }}</button>
    </script>
    где то там в html надо
-->
        <!--<button-counter></button-counter>-->

        <anchored-heading>Привет, мир!</anchored-heading>


    </span>
</template>


<!--    <script type="text/x-template" id="anchored-heading-template">
        <h1>
        <slot></slot>
        </h1>
</script>-->


<script>


    import Vue from 'vue'

    var c = {
        data: function () {
            return {
                count: 0
            }
        },
        template: '<span>Just Span</span>'
    }


    Vue.component('anchored-heading', {
        //template: '#anchored-heading-template',
        render: function (createElement) {
            /*return createElement(
                'h1',
                this.$slots.default // массив дочерних элементов
            )*/
            /*return createElement(
                'h1',
                'just text'
            )*/
            /*return createElement(
                c
            )*/
            return createElement(

            )
        },
    })

    export default
        {
        data(){
            return {
            }
        },
        components:{
        },
        //template:'<span>Span</span>'
        //template:'#qwe'
    }



</script>