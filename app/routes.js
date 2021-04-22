/**
 * Created by Nurbek Nurjanov on 3/24/19.
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 */

import Vue from "vue";
import VueRouter from "vue-router";
Vue.use(VueRouter);

import Order1 from './components/order/Order1.vue'
import Order2 from './components/order/Order2.vue'
import Page from './components/page/Page.vue'
import Index from './components/site/Index.vue'
import Error from './components/site/Error.vue'
import Contact from './components/site/Contact.vue'
import ProductsList from './components/product/list/ProductsList.vue'
import Eav from './components/product/Eav.vue'
import Test from './components/test/Test5.vue'
import FavoriteList from './components/product/list/FavoriteList.vue'
import CompareList from './components/product/list/CompareList.vue'
import ProductView from './components/product/view/ProductView.vue'


let cat_urls = category_urls
let products_urls = category_urls.map(value=> value+'/*-:id');



let routes = [
    {
        path : '',
        component : Index
    },
    {
        path : 'site/contact',
        component : Contact
    },
    {
        path : 'about_us',
        component : Page
    },
    {
        path : 'guarantee',
        component : Page
    },
    {
        path : 'delivery',
        component : Page
    },
    {
        path : 'site/test',
        component : Test
    },
    {
        path : 'product/compare/index',
        component : CompareList
    },
    {
        path : 'order/order/create1',
        component : Order1
    },
    {
        path : 'order/order/create2',
        component : Order2
    },
]

if(!language){
    routes = routes.map(value=> {
        value.path = '/'+value.path;
        return value;
    });
    routes = routes.concat([
        {
            path : '/products',
            alias: cat_urls.map(value=> '/'+value),
            components: {
                default: ProductsList,
                eavBlockView: Eav,
            }
        },
        {
            path : '/product/product/favorites',
            components: {
                default: FavoriteList,
                eavBlockView: Eav,
            }
        },
        {
            path : '/product/product/view/:id',
            alias: products_urls.map(value=> '/'+value),
            component: ProductView
        },
    ])
}
else{
    routes = routes.concat([
        {
            path : 'product/product/view/:id',
            alias: products_urls,
            component: ProductView
        },
    ])
    routes = [
        {
            path : '/:language/products',
            alias: cat_urls.map(value=> '/:language/'+value),
            components: {
                default: ProductsList,
                eavBlockView: Eav,
            }
        },
        {
            path : '/:language/product/product/favorites',
            components: {
                default: FavoriteList,
                eavBlockView: Eav,
            }
        },
        {
            path:'/:language',
            component : {
                template:'<div><router-view></router-view></div>',
            },
            children: routes
        },
    ]
}

routes = routes.concat([
    {
        path : '*',
        component : Error
    }
])



export {routes}


const router = new VueRouter ({
    //path:'/:language',
    //mode: 'hash',//history
    mode:'history',
    routes
})



window.router = router;
$('body').on('click', 'a', e=>{
    let $target = $(e.target);
    if(!$target.attr('href'))
        $target = $target.parents('a');
    let href = $target.attr('href');

    if($target.data('lightbox'))
        return false;
    if(!href)
        return false;
    if($target.parents('.categoriesBlock, #indexContent, .header, footer, .alert-success').length){
        e.preventDefault();
        router.push(href);
    }
})

export {router}