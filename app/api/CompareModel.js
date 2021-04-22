/**
 * Created by Nurbek Nurjanov on 4/2/19.
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 */


'use strict';


import axios from "axios";

function CompareModel() {

}

CompareModel.add = function(product_id)
{
    let items = this.findAll()
    items[product_id] = product_id
    localStorage.setItem("compareProducts", JSON.stringify(items))
}
CompareModel.delete = function (product_id)
{
    let items = this.findAll()
    delete items[product_id];
    localStorage.setItem("compareProducts", JSON.stringify(items))
}
CompareModel.count = function()
{
    let items = CompareModel.findAll()
    return Object.keys(items).length;
}

CompareModel.nProducts = function()
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

CompareModel.deleteAll = function()
{
    localStorage.setItem("compareProducts", JSON.stringify({}));
}


CompareModel.findAll = function () {
    //this.deleteAll();
    if(localStorage.getItem("compareProducts"))
        return JSON.parse(localStorage.getItem("compareProducts"));
    return {};
}

CompareModel.isAlreadyInCompare = function (product_id) {
    let items = this.findAll();
    if(items[product_id])
        return true;
    return false;
}




export default CompareModel