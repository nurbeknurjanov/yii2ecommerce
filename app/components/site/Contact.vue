<template>
    <div id="contactContent">
    </div>
</template>

<script>
    import axios from 'axios';
    export default {
        mounted() {
            axios
                .get(apiUrlWithLanguage+'/site/contact')
                .then(response => {
                    this.$store.commit('setTitle', {topTitle:response.data['data'].title});
                    this.$store.commit('setBreadCrumbs', [
                        response.data['data'].title
                    ])

                    $('#contactContent').html(response.data['data'].content);

                    setTimeout(_=>{
                        recaptchaOnloadCallback();
                    }, 1000)


                    $('#contact-form').data('yiiActiveForm').settings.validationUrl  = apiUrlWithLanguage+'/site/contact';


                    $('body').on('beforeSubmit', '#contact-form', _=>{
                        this.toSubmit();
                        return false;
                    });

                });
        },
        beforeDestroy:_=>{
            $('#contact-form').yiiActiveForm('destroy');
            $('body').off('beforeSubmit', '#contact-form');

            if (typeof grecaptcha !== 'undefined') {
                grecaptcha.reset(window.recaptchaClientId)
            }
        },
        methods: {
            toSubmit(){
                axios.post(apiUrlWithLanguage+'/site/contact', $('#contact-form').serialize())
                    .then(response=>{
                        $('#contactContent').html(response.data['data'].content);
                        setTimeout(_=>{
                            recaptchaOnloadCallback();
                        }, 1000)
                    })
            }
        },
    }
</script>