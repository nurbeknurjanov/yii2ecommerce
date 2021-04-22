/**
 * Created by Nurbek Nurjanov on 4/2/19.
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 */


'use strict';

import Vue from 'vue'
import axios from "axios";

class BasketModel
{
    constructor() {

    }

    static add(orderProduct)
    {
        let items = this.findAll()
        items[orderProduct.product_id] = orderProduct
        //Vue.set(items, orderProduct.product_id, orderProduct)
        localStorage.setItem("basketProducts", JSON.stringify(items))
    }
    static update(orderProduct)
    {
        BasketModel.add(orderProduct)
    }

    static delete(product_id)
    {
        let items = this.findAll();
        delete items[product_id];
        localStorage.setItem("basketProducts", JSON.stringify(items))
    }

    static count()
    {
        let items = this.findAll()
        return Object.keys(items).length;
    }
    static amount()
    {
        let amount=0
        let items = this.findAll()
        for (let key in items) {
            let orderProduct = items[key];
            amount+=(orderProduct.price * orderProduct.count);
        }
        return amount;
    }

    static deleteAll()
    {
        localStorage.setItem("basketProducts", JSON.stringify({}));
    }

    static nProducts()
    {
        return new Promise((resolve, reject) =>{
            axios
                .get(apiUrlWithLanguage+'/message/t',{
                    params: {
                        category: 'order',
                        word: 'nProducts',
                        n: this.count(),
                    }
                })
                .then(response => {
                    resolve(response.data['data'])
                });
        } );
    }
    static nProductsForAmount()
    {
        //this.deleteAll();
        return new Promise((resolve, reject) =>{
            axios
                .get(apiUrlWithLanguage+'/message/t',{
                    params: {
                        category: 'order',
                        word: 'nProductsForAmount',
                        amount: this.amount(),
                        n: this.count(),
                    }
                })
                .then(response => {
                    resolve(response.data['data'])
                });
        } );
    }

    static getProduct(product_id)
    {
        if(this.isAlreadyInBasket(product_id))
            return this.findAll()[product_id];
    }
}

//strelka bolboyt
BasketModel.findAll = function () {
    //this.deleteAll();
    if(localStorage.getItem("basketProducts"))
        return JSON.parse(localStorage.getItem("basketProducts"));
    return {};
}

BasketModel.isAlreadyInBasket = function (product_id) {
    let items = this.findAll();
    if(items[product_id])
        return true;
    return false;
}


export default BasketModel