/**
 * Created by Nurbek Nurjanov on 4/2/19.
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 */


'use strict';


import axios from "axios";

function FavoriteModel() {

}

FavoriteModel.add = function(product_id)
{
    let items = this.findAll()
    items[product_id] = product_id
    localStorage.setItem("favoriteProducts", JSON.stringify(items))
}
FavoriteModel.delete = function (product_id)
{
    let items = this.findAll()
    delete items[product_id];
    localStorage.setItem("favoriteProducts", JSON.stringify(items))
}
FavoriteModel.count = function()
{
    let items = FavoriteModel.findAll()
    return Object.keys(items).length;
}

FavoriteModel.nProducts = function()
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

FavoriteModel.deleteAll = function()
{
    localStorage.setItem("favoriteProducts", JSON.stringify({}));
}


FavoriteModel.findAll = function () {
    //this.deleteAll();
    if(localStorage.getItem("favoriteProducts"))
        return JSON.parse(localStorage.getItem("favoriteProducts"));
    return {};
}

FavoriteModel.isAlreadyInFavorite = function (product_id) {
    let items = this.findAll();
    if(items[product_id])
        return true;
    return false;
}




export default FavoriteModel