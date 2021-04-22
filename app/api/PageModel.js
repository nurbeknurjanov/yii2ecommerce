/**
 * Created by Nurbek Nurjanov on 4/2/19.
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 */


'use strict';


import axios from 'axios';


export var PageModel  = function ()
{

}
PageModel.findOne = function(path) {

    return new Promise(function(resolve) {
        axios
            .get(apiUrl+path, {
                params: {
                    expand: 'url,images'
                }
            })
            .then(response => {
                resolve(response.data['data'])
            })
    });
}


//module.exports = PageModel;
//const VARIABLE = require('./file');

/*
*
module.exports = {
    method: function() {},
    otherMethod: function() {}
}
exports.method = function() {};
exports.otherMethod = function() {};
var MyMethods = require('./myModule.js');
var method = MyMethods.method;
var otherMethod = MyMethods.otherMethod;
*/