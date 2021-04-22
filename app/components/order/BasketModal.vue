<template>


    <div id="basketModal" class="fade modal">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 style="display:inline;">{{t['Shopping cart']}}</h4>
                </div>
                <div class="modal-body">

                    <form id="basketForm" class="form-horizontal" method="post"
                          :action="formUrl"
                          @submit.prevent="onSubmit"
                    >


                        <div class="error-summary" style="display:none">
                            <p>Please fix the following errors:</p>
                            <ul></ul>
                        </div>

                        <div :class="[containerClass, 'field-orderproduct-product_id']">
                            <label :class="labelClass" for="orderproduct-product_id">{{t['Product']}}</label>
                            <div :class="inputDivClass">
                                <input type="hidden" id="orderproduct-product_id" name="OrderProduct[product_id]">
                                <span class="form-control spanBasketFieldStyle"></span>
                            </div>
                            <div :class="helpDivClass">
                                <div class="help-block"></div>
                            </div>
                        </div>

                        <div :class="[containerClass, 'field-orderproduct-price']">
                            <label :class="labelClass" for="orderproduct-price">{{t['Price']}}</label>
                            <div :class="inputDivClass">
                                <input type="hidden" id="orderproduct-price" name="OrderProduct[price]" >
                                <span class="form-control spanBasketFieldStyle"></span>$
                            </div>
                            <div :class="helpDivClass">
                                <div class="help-block"></div>
                            </div>
                        </div>

                        <div :class="[containerClass, 'field-orderproduct-count']">
                            <label :class="labelClass" for="orderproduct-count">{{t['Count']}}</label>
                            <div :class="inputDivClass">
                                <div class="input-group" style="width:70%;">
                                    <input type="text" id="orderproduct-count" class="form-control" name="OrderProduct[count]" >
                                    <span class="input-group-btn"><button class="btn btn-default">{{t['pc']}}</button></span>
                                </div>
                            </div>
                            <div :class="helpDivClass">
                                <div class="help-block"></div>
                            </div>
                        </div>

                        <div class="form-group buttons">
                            <div :class="helpDivClass">
                                <button @click="button='order2'" type="submit" class="btn btn-warning" name="buttonValue" value="order">
                                    {{t['Issue the order']}}
                                </button>
                                <button @click="button='order1'" type="submit" class="btn btn-default" name="buttonValue" value="next">
                                    {{t['Continue shopping']}}
                                </button>
                            </div>
                        </div>

                    </form>

                </div>

            </div>
        </div>
    </div>


</template>

<script>
    import axios from 'axios';
    import BasketModel from '../../api/BasketModel.js'
    //Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');

    export default {
        data(){
            return {
                helpDivClass:'col-lg-8 col-lg-offset-4 col-xs-8 col-xs-offset-4',
                labelClass:'col-lg-4 col-xs-4 control-label',
                inputDivClass:'col-lg-8 col-xs-8',
                containerClass:'form-group required',
                formUrl:apiUrlWithLanguage+'/order-product/validate',
                t:t,
                button:null
            }
        },
        methods: {
            onSubmit: function () {
                var $form = $('#basketForm');

                axios.post(apiUrlWithLanguage+'/order-product/validate', $form.serialize(),  {withCredentials: true})
                    .then(response=>{
                        let data = response.data['data'];

                        this.setErrors(data);

                        if(!data.errors){
                            let product_id = $form.find('[name="OrderProduct[product_id]"]').val();

                            BasketModel.add({
                                product_id:product_id,
                                price:$('#orderproduct-price').val(),
                                count:$('#orderproduct-count').val(),
                            })

                            this.$store.state.lastBuyButton.refreshCount();
                            this.$store.commit('updateBasketButtonText');
                            $('#basketModal').modal('hide');

                            if(this.button==='order2')
                                this.$router.push(baseUrlWithLanguage+'/order/order/create2');
                            else
                                this.$store.commit('notify', {type:'success', message:t['You added the item into shopping cart.']
                                        +'<br>'+'<a href="'+baseUrlWithLanguage+'/order/order/create1'+'">'+t['Go to the shopping cart']+'</a>'});
                        }

                    })
            },
            setErrors(data){
                ['product_id', 'price', 'count'].forEach((element, index)=> {
                    let $fieldContainer = $('.field-orderproduct-'+element);
                    if(data.errors && data.errors[element]){
                        $fieldContainer.removeClass('has-success').addClass('has-error');
                        $fieldContainer.find('.help-block').html(data.errors[element]);
                    }else{
                        $fieldContainer.removeClass('has-error').addClass('has-success');
                        $fieldContainer.find('.help-block').html('');
                    }
                });
            }
        },
    }


</script>