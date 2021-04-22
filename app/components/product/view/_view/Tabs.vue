<template>
    <fragment>
        <ul id="product-tabs" class="nav nav-tabs" tag="div">
            <li class="active">
                <a href="#fields" data-toggle="tab">Characteristics</a>
            </li>
            <li><a href="#comments" data-toggle="tab">Reviews(3)</a></li>
            <li v-if="product.description"><a href="#description" data-toggle="tab">Description</a></li>
        </ul>

        <div class="tab-content">
            <div id="fields" class="tab-pane active">
                <br>

                <table class="table detail-view product-detail-view">
                    <tbody>
                    <tr v-for="value in product.values">
                        <th>{{value.field.label}}</th>
                        <td>
                            <router-link v-if="value.field.clickable" :to="getValueClickLink(value)">{{value.valueText}}</router-link>
                            <span v-else >{{value.valueText}}</span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div id="comments" class="tab-pane">
            </div>
            <div id="description" class="tab-pane" v-if="product.description">
                <br>
                <p v-html="product.description"></p>
            </div>
        </div>
    </fragment>
</template>


<script>

    export default {
        props: ['product'],
        methods:{
            getValueClickLink(value){
                let u = {path: baseUrlWithLanguage+'/products'}
                let key = value.field.key
                u.query = {}
                let val = value.value;
                val = val.replace(/,/, '-');
                u.query[key] = val
                return u;
            },
        }
    }
</script>