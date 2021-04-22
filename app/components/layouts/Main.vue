<template>
    <fragment>
        <bread-crumb></bread-crumb>
        <!--alert-->
        <router-view>
        </router-view>
    </fragment>
</template>



<script>

    import BreadCrumb from "./elements/BreadCrumb.vue";
    export default {
        data(){
            return {
                simpleMain:1
            }
        },
        components: {
            BreadCrumb,
        },
    }
</script>
