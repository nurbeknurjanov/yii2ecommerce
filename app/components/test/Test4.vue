<template>
    <div>


        test3
        <br/>
        <button-counter></button-counter>
        <!--<anchored-heading>Привет, мир!</anchored-heading>
        <script type="text/x-template" id="anchored-heading-template">
            <h1>
                <slot></slot>
            </h1>
        </script>-->


    </div>
</template>

<script>


    import Vue from 'vue'

    Vue.component('button-counter', {
        data: function () {
            return {
                count: 0
            }
        },
        template: '<button v-on:click="count++">Счётчик кликов — {{ count }}</button>'
    })


    export default {
        data(){
            return {
            }
        },
        components:{
        }
    }
</script>