<template>

    <fragment>
        <div class="list-view-top">
            <div class="sort-block sort-ordinal">
                {{t['Sort by']}}:
                <router-link :to="getSortLink('price')" :class="getSortClass('price')" >{{t['price']}}</router-link>,
                <router-link :to="getSortLink('noveltyAttribute')" :class="getSortClass('noveltyAttribute')" >{{t['novelties']}}</router-link>,
                <router-link :to="getSortLink('popularAttribute')" :class="getSortClass('popularAttribute')" >{{t['popular']}}</router-link>,
                <router-link :to="getSortLink('rating')" :class="getSortClass('rating')" >{{t['rating']}}</router-link>
            </div>

            <div class="list-style-block">
                <a href="" v-on:click.prevent="switchStyle"  >
                    <i :class="['glyphicon', styleIcon]"></i>
                </a>

                <div class="per-page">
                    <i class="glyphicon glyphicon-option-vertical"></i>
                    <div class="per-page-container btn-group">
                        <button class="btn dropdown-toggle" data-toggle="dropdown">
                            {{$route.query['per-page'] ? $route.query['per-page']:20}}
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" style="min-width:auto">
                            <li v-for="perPage in [10, 20, 50, 100]">
                                <router-link :to="getPageLink(perPage)" >{{perPage}}</router-link>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
        <div class="clear"></div>
    </fragment>

</template>
<script>

    export default {
        data() {
            return {
                t:t,
                style:localStorage.getItem("style") || 'asTab',
            };
        },

        computed:{
            styleIcon(){
                if(this.style==='asTab')
                    return 'glyphicon-th-list';
                else if(this.style==='asList')
                    return 'glyphicon-th';
            },
        },
        methods:{
            getSortClass(sortName){
                if(this.$route.query.sort===sortName)
                    return 'asc';
                if(this.$route.query.sort==='-'+sortName)
                    return 'desc';
            },
            prepareLink(){
                let u = { path: this.$route.path, query:{}}
                for(var key in this.$route.query)
                    u.query[key] = this.$route.query[key];
                return u;
            },
            getSortLink(sortName){
                let u = this.prepareLink();
                if(this.$route.query.sort===sortName)
                    u.query.sort = '-'+sortName;
                else {
                    if(this.$route.query.sort==='-'+sortName)
                        u.query.sort = sortName;
                    else
                        u.query.sort = sortName;
                }
                return u;
            },
            getPageLink(perPage){
                let u = this.prepareLink();
                u.query['per-page'] = perPage;
                return u;
            },
            switchStyle(){
                if(this.style==='asTab')
                    this.style = 'asList'
                else if(this.style==='asList')
                    this.style = 'asTab'

                this.$emit('onListen', this.style);

                localStorage.setItem("style", this.style)
            }
        },
    }
</script>