<script>

    import ProductsList from './ProductsList.vue';
    import {ProductModel} from '../../../api/ProductModel.js'


    export default {
        extends: ProductsList,
        mounted() {
            //console.log(this.$refs.nurbek) is component
            //console.log(this.$refs.nurbek.innerText)
            //console.log(this.$refs.nurbek.innerHTML)
            //this.id = this._uid
        },

        methods: {

            async refreshProducts(fullPath) {
                this.loadingShow=true;
                //var result = await ProductModel.findAll(fullPath)
                var result = await ProductModel.findAllFavorites(fullPath)

                var data = result.data;

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

                /*$('#listView .items').infinitescroll({
                    "loading": {
                        "msgText": "<em>Loading next set of items...</em>",
                        "finishedMsg": "<em>No more items to load</em>",
                        "img": "/assets/bcd2b30d/ajax-loader.gif"
                    },
                    "behavior": "twitter",
                    "maxPage": this.pagination.pageCount,
                    "contentSelector": "#listView .items",
                    "itemSelector": "#listView .items >",
                    "navSelector": "#listView ul.paginationOther",
                    "nextSelector": "#listView ul.paginationOther li.next a:first"
                }, function (data) {
                    $('.product-rating-class').rating({
                        "showClear": false,
                        "size": "xs",
                        "step": 1,
                        "showCaption": false,
                        "displayOnly": true,
                        "language": "ru"
                    });
                });*/

            },

            setBreadCrumbs(data) {
                let breadCrumbLinks = [];
                breadCrumbLinks = breadCrumbLinks.concat([data.breadCrumbTitle])
                this.$store.commit('setBreadCrumbs', breadCrumbLinks)
            },

        }
    }
</script>