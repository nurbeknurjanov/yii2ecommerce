<template>
    <div>
        <component v-bind:is="layout"></component>
        <basket-modal></basket-modal>
    </div>
</template>

<script>

    import mainLayout from "./Main.vue";
    import mainLayoutProduct from "./MainProduct.vue";
    import BasketModal from "../order/BasketModal.vue"

    export default {
        data() {
            return {
                layout: 'mainLayout',
            };
        },
        watch: {
            '$route.fullPath': {
                handler: function (fullPath) {

                    let matched = null;
                    if(this.$route.matched[1])
                        matched = this.$route.matched[1];
                    else if(this.$route.matched[0])
                        matched = this.$route.matched[0];

                    if(matched && matched.components.default.methods && matched.components.default.methods.refreshProducts)
                        this.layout = 'mainLayoutProduct'
                    else
                        this.layout = 'mainLayout'

                },
                immediate: true
            },
        },

        components: {
            mainLayout,
            mainLayoutProduct,
            BasketModal,
        },
    }


</script>
