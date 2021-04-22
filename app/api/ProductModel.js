/**
 * Created by Nurbek Nurjanov on 4/2/19.
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 */


'use strict';


import axios from 'axios';
import CompareModel from './CompareModel.js'
import FavoriteModel from './FavoriteModel.js'

class ProductModel
{
    constructor(/*version*/)
    {
        //this is object properties
        //this.version = version;
    }


    static async findAllFavorites(fullPath)
    {

        return await axios
            //.get(apiUrlWithLanguage+'/product/favorites',
            .get(apiUrl+fullPath,
                {
                params: {
                    ids:Object.keys(FavoriteModel.findAll()).toString(),
                    expand: 'url,images,values',
                }
            })
            .then(response => {
                this.eavData = response.data['data'].eavBlock;
                return {
                    'data':response.data['data'],
                    'headers': response.headers
                }
            });
    }
    static async findAllCompare()
    {
        return await axios
            .get(apiUrlWithLanguage+'/product/compare', {
                params: {
                    ids:Object.keys(CompareModel.findAll()).toString(),
                    expand: 'url,images,values',
                }
            })
            .then(response => response.data['data']);
    }
    static async findAll(fullPath)
    {
        /*while(fullPath.charAt(0) === '/')
            fullPath = fullPath.substr(1);
*/
        return await axios
            .get(apiUrl+fullPath,{
                params: {
                    expand: 'url,images,imageUrl',
                }
            })
            .then(response => {
                this.eavData = response.data['data'].eavBlock;
                return {
                    'data':response.data['data'],
                    'headers': response.headers
                }
            });
    }
    static async findAllById(ids)
    {
        ids = ids.toString();
        return await axios
            .get(apiUrlWithLanguage+'/product/find-all-by-id',{
                params: {
                    ids:ids,
                    expand: 'url,images,imageUrl',
                }
            })
            .then(response => response.data['data']);
    }

    static findOne(id, expand='url,images')
    {
        return new Promise((resolve, reject) =>{
            axios
                .get(apiUrlWithLanguage+'/products/'+id,{
                    params: {
                        expand: expand,
                    }
                })
                .then(response => {
                    resolve(response.data['data'])
                });
        } );
    }

    /*    // геттер
        get fullName() {
            return `${this.firstName} ${this.lastName}`;
        }

        // сеттер
        set fullName(newValue) {
            [this.firstName, this.lastName] = newValue.split(' ');
        }
    */
}


//static property after class is defined
ProductModel.eavData=''



/*var animal = {
    eats: true
};
var rabbit = {
    jumps: true
};

rabbit.__proto__ = animal;

// в rabbit можно найти оба свойства
alert( rabbit.jumps ); // true
alert( rabbit.eats ); // true*/



// var ProductApi = ProductModel
// ProductApi.prototype.sayHi = _ => {
//     //alert('Hi from prototipe 2');
// };

//ProductApi.printMe()

export { ProductModel };