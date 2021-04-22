import Vue from "vue";
import Vuex from "vuex";
Vue.use(Vuex);

import axios from "axios";
import BasketModel from "./api/BasketModel.js"


/**
 * Created by Nurbek Nurjanov on 8/15/19.
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 */


export const store = new Vuex.Store({
    state: {
        appName:appName,
        slogan:t['slogan'],

        topTitle: '',
        menuTitle: '',
        basket:{},

        links:[],
        lastBuyButton:null
    },

    mutations: {
        setTitle(state, titleObject={}){

            if(!Object.keys(titleObject).length){
                state.topTitle = null;
                state.menuTitle = null;
                state.title = null;
            }

            if(titleObject.topTitle){
                state.topTitle=titleObject.topTitle
                state.menuTitle=''
            }
            if(titleObject.menuTitle){
                state.topTitle=''
                state.menuTitle=titleObject.menuTitle
            }

            if(titleObject.title){
                state.topTitle=''
                state.menuTitle=''
            }else{
                if(titleObject.topTitle)
                    titleObject.title = titleObject.topTitle;
                else{
                    if(titleObject.menuTitle)
                        titleObject.title = titleObject.menuTitle;
                }
            }

            if(titleObject.fullTitle){
                state.topTitle=''
                state.menuTitle=''
                state.title=''
            }else{
                if(titleObject.title)
                    titleObject.fullTitle = titleObject.title+' | '+ state.appName;
                else
                    titleObject.fullTitle = state.appName+' - '+ state.slogan;
            }
            $('title').html(titleObject.fullTitle);
        },
        updateBasketButtonText(state) {

            BasketModel.nProductsForAmount().then(nProductsText=>{
                state.basket = {
                    text:nProductsText,
                    count:BasketModel.count()
                }
            })

        },
        setBreadCrumbs(state, links) {
            if(typeof links !== 'undefined' && links.length > 0)
                links = [{label:t['Home'], url: ''}].concat(links)
            state.links = links;
        },
        notify(state, notify) {
            $.notify({
                message: notify.message,
            },{
                type: notify.type,
                //timer: 10000000,
                placement: {
                    from: 'top',
                    align: 'right'
                }
            });
        },
    },
})

