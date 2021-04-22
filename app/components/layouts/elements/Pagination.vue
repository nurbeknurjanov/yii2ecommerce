<template>


    <fragment>

        <ul class="pagination" v-if="pageCount>1" >

            <li :class="['prev', prevDisabled()]" >
                <span v-if="prevDisabled()">«</span>
                <router-link :to="getPageLink((parseInt($route.query['page'] || 1)-1))"  v-else >«</router-link>
            </li>


            <li v-for="count in parseInt(pageCount)"  :class="active(count)" >
                <router-link :to="getPageLink(count)" >{{count}}</router-link>
            </li>


            <li :class="['next', nextDisabled()]">
                <span v-if="nextDisabled()">»</span>
                <router-link :to="getPageLink((parseInt($route.query['page'] || 1)+1))"  v-else >»</router-link>
            </li>
        </ul>

    </fragment>


</template>

<script>

    export default {
        props: ['pagination'],
        data() {
            return {
                currentPage: 1,
                pageCount: 0,
                perPage:20,
                totalCount:0
            };
        },
        created() {
            this.refreshPagination();
        },
        watch: {
            pagination: {
                immediate: true,
                deep: true,
                handler(newValue, oldValue) {
                    this.refreshPagination();
                }
            }
        },
        methods: {
            refreshPagination:function(){
                this.currentPage=this.pagination.currentPage
                this.pageCount=this.pagination.pageCount
                this.perPage=this.pagination.perPage
                this.totalCount=this.pagination.totalCount
            },
            active(count){
                if(this.$route.query['page'])
                    return count==this.$route.query['page'] ? 'active':''
                if(count==1)
                    return 'active';
            },

            prevDisabled(){
                if(this.active(1))//когда нажат первый
                    return 'disabled';
            },
            nextDisabled(){
                if(this.active(this.pageCount))//когда нажат последний
                    return 'disabled';
            },

            prepareLink(){
                let u = { path: this.$route.path, query:{}}
                for(var key in this.$route.query)
                    u.query[key] = this.$route.query[key];
                return u;
            },
            getPageLink(count){
                var u = this.prepareLink();
                u.query['page'] = count;
                return u;
            },
        },
    }
</script>