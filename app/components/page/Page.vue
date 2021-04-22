<template>
    <div>

        <h1 class="title" v-html="page.title"></h1>

        <p v-html="page.text"></p>

        <div v-if="page.images" >
            <a v-for="(image, n) in page.images"
               :href="image.imageUrl"
               :class="'image-'+n"
               :id="'lightbox-'+image.id"
               data-lightbox="roadtrip">
                <img :src="image.thumbUrlMd" />
            </a>
        </div>

    </div>
</template>

<script>
    import {PageModel} from '../../api/PageModel.js'

    export default {
        data () {
            return {
                page: {},
            };
        },
        created() {
            this.refreshPage(this.$route.path);
        },
        watch: {
            '$route.path' (path) {
                this.refreshPage(path);
            }
        },
        methods: {

            async refreshPage(path) {

                this.page = await PageModel.findOne(path);

                this.$store.commit('setTitle', {topTitle:this.page.title});

                this.$store.commit('setBreadCrumbs', [
                    this.page.title
                ])
            },
        },
    }
</script>