<template>
    <fragment>
        <!--main product time : {{now}}-->
        <bread-crumb></bread-crumb>
        <h1 class="fullPageSearchTitle">
            {{fullPageSearchTitle}}
        </h1>
        <h1 class="fullPageCategoryTitle">
            {{fullPageCategoryTitle}}
        </h1>

        <ul class="categoryBlock" v-if="childrenCategories.length>0">
            <li v-for="cat in childrenCategories">
                <router-link :to="cat.url" style="font-weight:600; color: #535353;" >
                    <img class="category-icon" v-if="cat.imageUrl!=null" :src="cat.imageUrl" alt="">
                    {{cat.title}}
                </router-link>
            </li>
        </ul>

        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-12">
                <router-view name="eavBlockView" ref="eavRef">
                </router-view>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-12">
                <!--alert-->
                <router-view>
                </router-view>
            </div>
        </div>
    </fragment>
</template>

<script>

    import BreadCrumb from "./elements/BreadCrumb.vue";
    export default {
        data() {
            return {
                fullPageSearchTitle: null,
                fullPageCategoryTitle: null,
                childrenCategories: [],
            };
        },
        computed:{
            /*now: function () {
                return Date.now()
            },*/
        },
        components: {
            BreadCrumb,
        },
    }
</script>
