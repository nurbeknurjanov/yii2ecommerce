<template>
    <div @click="change">
        {{ message }}
    </div>
</template>

<script>


    import Vue from 'vue'


    export default {
        data(){
            return {
                message: '123'
            }
        },
        components:{
        },
        methods:{
            change(){
                this.message = 'новое сообщение' // изменяем данные
                //this.$el.textContent === 'новое сообщение' // false
                Vue.nextTick(function () {
                    alert(1+'');
                    //this.$el.textContent === 'новое сообщение' // true
                })
            }
        }
    }


</script>