<template>


    <fragment>

        <ul class="paginationOther" style="padding:0"  v-if="pageCount>1 && !nextDisabled()">
            <li class="next" @click.capture="nextClick" >
                <router-link :to="getPageLink(parseInt($route.query['page'] || 1) +1)"
                             class="btn btn-primary"  >
                    {{t['Load more']}}
                </router-link>
            </li>
        </ul>

    </fragment>


</template>

<script>

    import Pagination from './Pagination.vue';


    export default {
        data() {
            return {
                t:t,
                currentPage: 1,
                pageCount: 0,
                perPage:20,
                totalCount:0
            };
        },
        extends: Pagination,
        methods: {
            refreshPagination:function(){
                this.currentPage=this.pagination.currentPage
                this.pageCount=this.pagination.pageCount
                this.perPage=this.pagination.perPage
                this.totalCount=this.pagination.totalCount

                this.$parent.concat = false;
            },
            nextClick(e){
                e.preventDefault()
                this.$parent.concat = true;
                this.$router.push($(e.target).attr('href'));
            },
        },
    }

    /*
    * var u = new Url;
                u.path = '/#' + this.$route.path;
                u.hash = '';
                for (var key in this.$route.query)
                    u.query[key] = this.$route.query[key];
                return u;
*/
</script>