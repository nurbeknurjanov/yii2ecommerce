<template>
    <div>

        <slot name="header">
            Старый дефоултный хедер
        </slot>



        <br/>

        <slot v-bind:slotVariable="slotVariable">Старый дефоултный контент  => {{slotVariable}}</slot>
        <br/>


        <slot name="footer"></slot>
        <br/>


        <slot name="underFooter">
            Какой то контент Под футером
        </slot>

    </div>
</template>

<script>

    //v-bind:userName="userName" dlya otpravki vverh
    export default {
        data(){
            return {
                slotVariable:'Some slot variable'
            }
        }
    }
</script>