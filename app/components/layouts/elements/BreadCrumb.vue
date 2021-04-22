<template>
    <ul class="breadcrumb"  v-if="show" >
        <li v-for="link in links" :class="{active:!link.label}" >
            <router-link  v-if="link.label" :to="link.url ? link.url:baseUrlWithLanguage+'/'" >{{link.label}}</router-link>
            <template v-else>{{link}}</template>
        </li>
    </ul>
</template>

<script>
    export default {
        data(){
            return {
                baseUrlWithLanguage:baseUrlWithLanguage
            }
        },
        computed:{
            show(){
                if(this.$store.state.links)
                    return true;
                return false
            },
            links(){
                return this.$store.state.links
            }
        }
    }
</script>