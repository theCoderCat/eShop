<template>
    <div>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
        <div class="text-right">
            <!--Open User Creating Modal-->
            <router-link :to="{ name: 'create-article' }" class="btn btn-primary mb-xs-10">+ New Article</router-link>
        </div>
        <div class="row">
            <!--main-->
            <div class="col-md-12">
                <table class="table product-table">
                    <thead>
                    <tr>
                        <td></td>
                        <td>Title</td>
                        <td>Slug</td>
                        <!--<td>Category</td>-->
                        <td>Status</td>
                        <td></td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="p in articles">
                        <td><img v-if="p.featured_image" :src="p.featured_image.url" alt="" class="featured-img"></td>
                        <td><a :href="p.slug" target="_blank">{{p.title}}</a></td>
                        <td>{{p.slug}}</td>
                        <!--<td>{{p.category}}</td>-->
                        <td>{{p.active}}</td>
                        <td>
                            <router-link :to="{ name: 'edit-article', params: { articleId: p.id } }" class="btn btn-primary mb-xs-10">Edit</router-link>
                            <a href="" class="btn btn-danger">x Delete</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        mounted() {
            console.log('Product List ready.');
        },
        created() {
            // fetch the data when the view is created and the data is
            // already being observed
            this.fetchArticles();
        },
        components: {
            Modal
        },
        data() {
            return {
                loading: false,
                error: null,
                api: this.$root.$data.api,
                articles: [],
            };
        },
        methods: {
            fetchArticles() {
                //
                axios.get(this.api.getAllArticles)
                    .then((res) => {
                        // success
                        this.articles = res.data.allItems;
                    })
                    .catch((error) => {
                        //
                        console.log(error);
                        alert('cannot fetch articles');
                    });
            },
        }
    }
</script>