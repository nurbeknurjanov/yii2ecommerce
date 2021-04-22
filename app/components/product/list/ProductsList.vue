<template>
    <fragment>
        
        <h1 class="title">{{pageTitle}}</h1>
        
        <sort-block v-on:onListen="changeStyle"></sort-block>

        <div class="clear"></div>

        <div id="listView" class="list-view">
            <div class="items">
                <div class="item" v-for="product in products" :data-key="product.id">
                    <products-list-tab-element v-if="style=='asTab'"
                                               :product="product"></products-list-tab-element>
                    <products-list-list-element v-if="style=='asList'"
                                                :product="product"></products-list-list-element>
                </div>
                <img :src="infiniteScrollImageUrl" v-if="loadingShow" />
            </div>
            <div class="clear"></div>
            <!--<pagination :pagination="pagination"></pagination>-->
            <pagination-endless :pagination="pagination"></pagination-endless>
        </div>

    </fragment>
</template>

<script>

    import ProductsListTabElement from './_list/ProductsListTabElement.vue';
    import ProductsListListElement from './_list/ProductsListListElement.vue';
    import SortBlock from './SortBlock.vue';
    import Pagination from '../../layouts/elements/Pagination.vue';
    import PaginationEndless from '../../layouts/elements/PaginationEndless.vue';
    import {ProductModel} from '../../../api/ProductModel.js'


    export default {
        created() {
            this.refreshProducts(this.$route.fullPath);
        },
        watch: {
            '$route.fullPath'(fullPath) {
                this.refreshProducts(fullPath);
            }
        },
        data() {
            return {
                id:'productsList',
                style: localStorage.getItem("style") || 'asTab',
                loadingShow: false,
                products: [],
                pageTitle: null,
                pagination: {},
                headers: [],
                concat:false,
                infiniteScrollImageUrl:infiniteScrollImageUrl,
            };
        },

        methods: {
            changeStyle: function (style) {
                this.style = style
            },
            async refreshProducts(fullPath) {
                this.loadingShow=true;
                var result = await ProductModel.findAll(fullPath)

                var data = result.data;
                this.$parent.fullPageSearchTitle = data.fullPageSearchTitle;
                this.$parent.fullPageCategoryTitle = data.fullPageCategoryTitle;
                this.$parent.childrenCategories = data.childrenCategories;


                this.$parent.$refs.eavRef.refreshData()


                this.pageTitle = data.pageTitle;

                this.$store.commit('setTitle', {
                    menuTitle: data.menuTitle,
                    topTitle: data.topTitle,
                    title: data.title,
                })

                this.setBreadCrumbs(data);

                //this.products.concat = [].concat;
                if(!this.concat)
                    this.products = data.products;
                else
                    this.products = this.products.concat(data.products);
                this.loadingShow=false;
                this.setPagination(result.headers);
            },
            setBreadCrumbs(data) {
                var breadCrumbLinks = [];
                if (data.category) {
                    breadCrumbLinks = breadCrumbLinks.concat([{label: t['All products'], url: baseUrlWithLanguage+'/products'}])
                    data.parentCategories.map(category => {
                        breadCrumbLinks = breadCrumbLinks.concat([{label: category.title, url: category.url}])
                    })
                }
                breadCrumbLinks = breadCrumbLinks.concat([data.breadCrumbTitle])
                this.$store.commit('setBreadCrumbs', breadCrumbLinks)
            },
            setPagination(headers) {
                this.pagination = {
                    currentPage: headers['x-pagination-current-page'],
                    pageCount: headers['x-pagination-page-count'],
                    perPage: headers['x-pagination-per-page'],
                    totalCount: headers['x-pagination-total-count'],
                };
            },
        },
        components: {
            ProductsListTabElement,
            ProductsListListElement,
            SortBlock,
            Pagination,
            PaginationEndless,
        }
    }
</script>