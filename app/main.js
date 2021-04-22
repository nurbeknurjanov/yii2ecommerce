import Vue from 'vue'
import Fragment from "vue-fragment";
Vue.use(Fragment.Plugin);

import axios from 'axios';
axios.defaults.headers.common['Authorization'] = 'Bearer token1';
axios.defaults.headers.common['SomeHeader'] = 'Some Header Value';


/*import * as say from "./test.js";
say.sayHi('Nurbek')*/


/*import {sayHi as hi, months} from "./test";
hi('Nurbek')*/

/*import months from "./test";
alert(months);*/

import {router} from './routes.js'
import {store} from './store.js'

import Header from './components/layouts/Header.vue'
new Vue({
    el: '#header',
    router,
    store,
    render(h){
        return h(Header)
    },
})



import Base from './components/layouts/Base.vue'
new Vue({
    data:{
        foo:'Foo',
    },
    router,
    store,
    el: '#app',
    render: createElement => createElement(Base),
})