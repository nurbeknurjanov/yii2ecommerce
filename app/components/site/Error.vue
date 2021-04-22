<template>
    <div class="site-error">

        <h1>Not Found (#404)</h1>

        <div class="alert alert-danger">
            Page not found.
        </div>

        <p>
            The above error occurred while the Web server was processing your request.
        </p>
        <p>
            Please contact us if you think this is a server error. Thank you.
        </p>

    </div>
</template>


<script>
    import axios from 'axios';
    import BuyButton from '../product/BuyButton.vue'
    import Vue from 'vue'

    export default {
        data () {
            return {
            };
        },
    }
</script>