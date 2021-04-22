<template>
    <div>

        <h1 class="title" v-html="title"></h1>


        <form id="order2Form" class="form-horizontal" method="post" v-on:submit.prevent="submitForm">

            <div class="error-summary" style="display:none">
                <p>Please fix the following errors:</p>
                <ul></ul>
            </div>

            <order-products
                    :order-products="orderProducts"
            />

            <div class="row orderCreate2">
                <div class="col-lg-6 col-xs-6">
                    <h3>{{t['Information about buyer']}}</h3>

                    <br>

                    <div v-for="(fieldName, index) in ['name', 'email', 'phone', 'city_id', 'address','description']"
                         :class="formGroupClass(fieldName)">

                        <template v-if="fieldName==='description'">
                            <label :class="labelClass" :for="'order-'+fieldName">{{t['DescriptionOrder']}}</label>
                            <div :class="inputClass">
                                <textarea  :name="'Order['+fieldName+']'" :id="'order-'+fieldName" class="form-control"  rows="6"></textarea>
                            </div>
                            <div :class="errorClass">
                                <div class="help-block">{{errors[fieldName]}}</div>
                            </div>
                        </template>

                        <template v-else-if="fieldName==='city_id'">
                            <label :class="labelClass" :for="'order-'+fieldName">{{t['City']}}</label>
                            <div :class="inputClass">
                                <select id="order-city_id" class="selectpicker city_id"
                                        name="Order[city_id]"
                                        data-live-search="true"
                                        data-width="100%"
                                        :data-title="t['Select']"
                                        :data-header="t['Select']"
                                        :data-url="baseUrlWithLanguage+'/country/city/select-picker'">
                                    <option value="">{{t['Select']}}</option>
                                </select>
                            </div>
                            <div :class="errorClass">
                                <div class="help-block">{{errors[fieldName]}}</div>
                            </div>
                        </template>

                        <template v-else>
                            <label :class="labelClass" :for="'order-'+fieldName">{{t[capitalize(fieldName)]}}</label>
                            <div :class="inputClass">
                                <input :name="'Order['+fieldName+']'" :id="'order-'+fieldName" type="text"  class="form-control" maxlength="255">
                            </div>
                            <div :class="errorClass">
                                <div class="help-block">{{errors[fieldName]}}</div>
                            </div>
                        </template>

                    </div>


                </div>

                <div class="col-lg-6 col-xs-6">

                    <div class="well">
                        {{t['In order']}} {{nProducts}}:
                        <ul style="list-style-type: decimal;">
                            <li v-for="(orderProduct, key, index) in orderProducts"
                                :product="product = products[orderProduct.product_id]" :data-key="key">
                                <router-link :to="product.url" style="color: #333;">
                                    {{product.title}}
                                </router-link>
                                <br>
                                {{orderProduct.count}} pc × {{product.priceCurrency}} = {{orderProduct.count *
                                orderProduct.price}}
                            </li>
                        </ul>
                        <br>
                        <b>{{t['Total to pay']}}: {{amount}}</b>
                        <br>
                        <br>
                        <router-link :to="backUrl">
                            <i class="glyphicon glyphicon-chevron-left"></i>
                            {{t['Back to shopping cart']}}
                        </router-link>
                    </div>

                    <h3 style="margin: 20px 0;">{{t['Delivery']}}</h3>
                    <div :class="formGroupClass('delivery_id')">
                        <div :class="inputClass">
                            <select id="order-delivery_id" class="form-control" name="Order[delivery_id]" >
                                <option value="1">{{t['Pickup']}}</option>
                                <option value="2">{{t['{name} Delivery service'].replace('{name}', appName)}}</option>
                                <option value="3">DHL</option>
                            </select>
                        </div>
                        <div :class="errorClass">
                            <div class="help-block">{{errors['delivery_id']}}</div>
                        </div>
                    </div>


                    <h3 style="margin: 40px 0 20px;">{{t['Payment type']}}</h3>
                    <div :class="formGroupClass('payment_type')" >

                        <div :class="inputClass">
                            <select id="order-payment_type" class="form-control"  name="Order[payment_type]" v-model="payment_type" >
                                <option :value="PAYMENT_TYPE_CASH">{{t['Cash']}}</option>
                                <option :value="PAYMENT_TYPE_ONLINE">{{t['Online']}}</option>
                            </select>
                        </div>
                        <div :class="errorClass">
                            <div class="help-block">{{errors['payment_type']}}</div>
                        </div>
                    </div>

                    <div class="cardButtons" v-if="payment_type===PAYMENT_TYPE_ONLINE" >
                        <div id="order-online_payment_type" :class="['form-control btn-group', formGroupClass('online_payment_type', false)]"  >
                            <label :class="radioButtonClass(ONLINE_PAYMENT_TYPE_CARD)" >
                                <input type="radio" name="Order[online_payment_type]"  :value="ONLINE_PAYMENT_TYPE_CARD" v-model="online_payment_type" style="display: none" >
                                <img :src="cardImageUrl" alt="" style="height:30px;">
                                <div class="hint-block" style="font-size: 12px; text-align: left">
                                    Fake Visa account:<br>
                                    Card number:4032 0300 3777 5674<br>
                                    Expiration date:12/2023 &nbsp;&nbsp;&nbsp; CVV:123
                                </div>
                            </label>
                            <label :class="radioButtonClass(ONLINE_PAYMENT_TYPE_PAYPAL)" >
                                <input type="radio"  name="Order[online_payment_type]" :value="ONLINE_PAYMENT_TYPE_PAYPAL" v-model="online_payment_type" style="display: none">
                                <img :src="paypalImageUrl" alt="" style="height:30px;">
                                <div class="hint-block" style="font-size: 12px; text-align: left">
                                    Fake Paypal account:<br>
                                    Login:buyer@sakuracommerce.com<br>
                                    Password:3@Rz%V3Gy"t^ctuS
                                </div>
                            </label>
                        </div>
                        <div class="help-block">{{errors['online_payment_type']}}</div>
                    </div>
                    <br>

                    <div class="card" v-if="online_payment_type===ONLINE_PAYMENT_TYPE_CARD && payment_type===PAYMENT_TYPE_ONLINE">
                        <div class="cardWhite">
                            <img :src="cardImageUrl"  style="height:40px;">

                            <div :class="formGroupClass('number',false)">
                                <label class="control-label" style="padding-left:0; text-align:left;" for="card-number">
                                    {{t['Card number']}}
                                </label>
                                <input type="hidden" id="card-number" name="Card[number]">
                                <div class="digits">
                                    <div class="field-card-digits1 required">
                                        <input type="text" id="card-digits1" class="form-control" name="Card[digits1]"  maxlength="4" >
                                    </div>
                                    <div class="field-card-digits2 required">
                                        <input type="text" id="card-digits2" class="form-control" name="Card[digits2]"  maxlength="4" >
                                    </div>
                                    <div class="field-card-digits3 required">
                                        <input type="text" id="card-digits3" class="form-control" name="Card[digits3]"  maxlength="4" >
                                    </div>
                                    <div class="field-card-digits4 required">
                                        <input type="text" id="card-digits4" class="form-control" name="Card[digits4]"  maxlength="4" >
                                    </div>
                                </div>
                                <div class="help-block">{{errors['number']}}</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-7 col-sm-7 col-xs-12">
                                    <div :class="formGroupClass('name',false)">
                                        <label class="control-label" style="padding-left:0; text-align:left;"  for="card-name">
                                            {{t['Name']}}
                                        </label>
                                        <input type="text" id="card-name" class="form-control" name="Card[name]"  >
                                        <div class="help-block">{{errors['name']}}</div>
                                    </div>
                                </div>
                                <div class="col-lg-5 col-sm-5 col-xs-12">
                                    <div :class="formGroupClass('expire_date',false)">
                                        <label class="control-label" style="padding-left:0; text-align:left;"  for="card-expire_date">
                                            {{t['Expire date']}}
                                        </label>
                                        <input type="hidden"  id="card-expire_date"    name="Card[expire_date]">
                                        <div class="row">
                                            <div class="col-xs-4" style="padding-right: 0">
                                                <div class=" field-card-expire_date_month required">
                                                    <input type="text" id="card-expire_date_month" class="form-control" name="Card[expire_date_month]" maxlength="2"   >
                                                </div>
                                            </div>
                                            <div class="col-xs-1" style="padding:3px 1px 0 1px;font-size: 20px; color: #878484; ">/</div>
                                            <div class="col-xs-6" style="padding-left: 0">
                                                <div class=" field-card-expire_date_year required">
                                                    <input type="text" id="card-expire_date_year" class="form-control"  name="Card[expire_date_year]" maxlength="4" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="help-block">{{errors['expire_date']}}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="cardBlack well">
                            <div class="ccv">
                                <div :class="formGroupClass('ccv')">
                                    <label :class="labelClass" for="card-ccv">CVV</label>
                                    <div :class="inputClass">
                                        <input type="text" id="card-ccv" class="form-control"  name="Card[ccv]" maxlength="3" style="width:40%" >
                                    </div>
                                    <div :class="errorClass">
                                        <div class="help-block">{{errors['ccv']}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="clearfix"></div>
                    <br>

                    <div class="form-group">
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-success btn-lg">
                                {{t['Make an order']}}
                                <i class="glyphicon glyphicon-send"></i>
                            </button>
                        </div>
                    </div>

                </div>
            </div>


        </form>

    </div>
</template>

<script>
    import BasketModel from '../../api/BasketModel.js'
    import {ProductModel} from '../../api/ProductModel.js'
    import axios from 'axios';
    import OrderProducts from './OrderProducts2.vue'


    export default {
        data() {
            return {
                title: t['Issue the order'],
                nProducts: '',
                orderProducts: [],
                products: [],
                backUrl: baseUrlWithLanguage + '/order/order/create1',
                t: t,
                labelClass: 'col-lg-4 col-xs-4 control-label',
                errorClass: 'col-lg-8 col-lg-offset-4 col-xs-8 col-xs-offset-4',
                inputClass: 'col-lg-8 col-xs-8',
                errors: [],
                fieldClasses: [],
                formSubmitted: false,
                baseUrlWithLanguage: baseUrlWithLanguage,
                appName: appName,
                cardImageUrl: cardImageUrl,
                paypalImageUrl: paypalImageUrl,
                PAYMENT_TYPE_CASH: PAYMENT_TYPE_CASH,
                PAYMENT_TYPE_ONLINE: PAYMENT_TYPE_ONLINE,
                ONLINE_PAYMENT_TYPE_PAYPAL: ONLINE_PAYMENT_TYPE_PAYPAL,
                ONLINE_PAYMENT_TYPE_CARD: ONLINE_PAYMENT_TYPE_CARD,
                payment_type:null,
                online_payment_type:null,
            }
        },
        computed: {
            amount() {
                let amount = 0;
                Object.values(this.orderProducts).forEach(orderProduct => {
                    amount += (orderProduct.count * orderProduct.price);
                })
                return amount;
            },
        },
        filters: {
            capitalize: (value) => {
                //this.capitalize(value)
            }
        },
        created() {
            this.setBreadCrumbs();
            BasketModel.nProducts().then(nProductsText => {
                this.nProducts = nProductsText
            })


            let ids = Object.keys(BasketModel.findAll());
            ProductModel.findAllById(ids).then(models => {
                this.products = models
                this.orderProducts = BasketModel.findAll();
            })

            let order = JSON.parse(localStorage.getItem("orderData"));
            this.payment_type = order['payment_type'];
            this.online_payment_type = order['online_payment_type'];
            axios
                .get(baseUrlWithLanguage+'/country/city/select-picker',{
                    params: {
                        value:order['city_id'],
                    }
                })
                .then(response => {
                    $(".selectpicker").html(response.data);
                    $(".selectpicker").val(order['city_id']);
                    $(".selectpicker").addClass("show-tick");
                    $(".selectpicker").selectpicker({"style":"btn-default form-control"});
                    $(":reset").click(function(){
                        $(this).closest("form").trigger("reset");
                        $(".selectpicker").selectpicker("refresh");
                    });
                });

        },
        components: {
            OrderProducts
        },
        mounted(){
            let order = JSON.parse(localStorage.getItem("orderData"));
            for (let key in order) {
                let val = order[key];
                if($('[name="Order['+key+']"]').length)
                    $('[name="Order['+key+']"]').val(val);
            }
            let card = JSON.parse(localStorage.getItem("cardData"));
            for (let key in card) {
                let val = card[key];
                if($('[name="Card['+key+']"]').length)
                    $('[name="Card['+key+']"]').val(val);
            }
        },
        methods: {
            capitalize: function (value) {
                if (!value) return ''
                value = value.toString()
                return value.charAt(0).toUpperCase() + value.slice(1)
            },
            setBreadCrumbs() {
                let breadCrumbLinks = [];
                breadCrumbLinks = breadCrumbLinks.concat([{
                    label: t['Shopping cart'],
                    url: baseUrlWithLanguage + '/order/order/create1'
                }])
                breadCrumbLinks = breadCrumbLinks.concat([this.title])
                this.$store.commit('setBreadCrumbs', breadCrumbLinks)
            },
            setErrors(data) {
                let er = [];
                ['name', 'email', 'phone','city_id', 'address', 'description',
                    'delivery_id','payment_type', 'online_payment_type',
                    'name',
                    'number',
                    'expire_date',
                    'ccv',
                ].forEach(element => {
                    if (data.errors && data.errors[element])
                        er[element] = data.errors[element];
                    else
                        er[element] = '';
                });
                this.errors = er;
            },
            formGroupClass(fieldName, formGroup=true) {
                return [
                    {'form-group': formGroup},
                    {'has-error': this.errors[fieldName]},
                    {'has-success': this.formSubmitted && !this.errors[fieldName]},
                    {'required': ['email', 'phone', 'city_id', 'address', 'delivery_id','payment_type'].includes(fieldName)},
                ]
            },
            radioButtonClass(value) {
                return [
                    'btn btn-default col-xs-5',
                    {'active': value===this.online_payment_type},
                ]
            },
            submitForm() {
                this.formSubmitted = true;
                let $form = $('#order2Form');
                axios.post(apiUrlWithLanguage + '/order/validate', $form.serialize())
                    .then(response => {
                        let data = response.data['data'];
                        this.setErrors(data);

                        if(!data.errors){
                            if(data.order)
                                localStorage.setItem("orderData", JSON.stringify(data.order) )
                            if(data.card)
                                localStorage.setItem("cardData", JSON.stringify(data.card))

                            axios.post(apiUrlWithLanguage + '/order/create2', $form.serialize())
                                .then(response => {
                                    //console.log(response);
                                    let responseData = response.data['data'];
                                    if(responseData.error)
                                        alert(responseData.error);
                                    else{
                                        if(responseData.approvalLink)
                                            window.location.href = responseData.approvalLink;
                                    }
                                })
                        }
                    })
            },
        },

    }
</script>