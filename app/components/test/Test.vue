<template>
    <div>

        <!--<slot-component>
                   Slot Content1 {{page.title}}
               </slot-component>-->
        <my-component>

            <!--<template v-slot:header>
                <h1>Новый хедер</h1>
            </template>-->
            <template #header>
                Новый хедер
            </template>


            <!--Новый контент-->
            <!--<template v-slot:default >
               Новый контент
            </template>-->

            <!--<template v-slot:default="slotProps" >
                Новый контент => {{slotProps.userName}}
            </template>-->
            <!--<template v-slot="slotProps"  >
               <p>Контент => {{slotProps.userName}}</p>
           </template>-->

            <!--<template #default="slotProps" >
                Новый контент => {{slotProps.slotVariable}}
            </template>-->
            <!--<template #default="{slotVariable}" >
                Новый контент по другому пропс => {{slotVariable}}
            </template>-->
            <!--<template v-slot:default="{slotVariable='new slot variable changed'}" >if slotVariable not assigned
                Новый контент по другому пропс => {{slotVariable}}
            </template>-->

            <template v-slot:[dynamicSlot] >
                Контент под футером
            </template>

            <template #footer>
                <p>Футер</p>
            </template>
        </my-component>


    </div>
</template>

<script>

    import MyComponent from './Slot2.vue'

    export default {
        data(){
            return {
                //dynamicSlot:'default'
                dynamicSlot:'underFooter',
            }
        },
        components:{
            MyComponent
        }
    }
</script>