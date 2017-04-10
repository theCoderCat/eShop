<template>
    <div>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
        <div class="text-right">
            <!--Open User Creating Modal-->
            <router-link :to="{ name: 'create-product' }" class="btn btn-primary mb-xs-10">+ New Product</router-link>
        </div>
        <div class="row">
            <!--main-->
            <div class="col-md-12">
                <table class="table product-table">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Name</td>
                            <td>Price</td>
                            <td>In Stock</td>
                            <td>Brand</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="p in products">
                            <td>{{p.id}}</td>
                            <td><a :href="p.url" target="_blank">{{p.name}}</a></td>
                            <td>{{p.price}}</td>
                            <td>{{p.in_stock}}</td>
                            <td><img class="brand-logo" v-if="p.brand" :src="p.brand.logo.url"></td>
                            <td>
                                <router-link :to="{ name: 'edit-product', params: { productId: p.id } }" class="btn btn-primary mb-xs-10">Edit</router-link>
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
            this.fetchProducts();
        },
        components: {
            Modal
        },
        data() {
            return {
                loading: false,
                error: null,
                modals: {
                    showCreateCategory: false,
                },
                api: this.$root.$data.api,
                products: [],
            };
        },
        methods: {
            fetchProducts() {
                //
                axios.get(this.api.getAllProducts)
                    .then((res) => {
                        // success
                        this.products = res.data.products;
                    })
                    .catch((error) => {
                        //
                        console.log(error);
                        alert('cannot fetch products');
                    });
            },

            editProduct(pID) {

            }
        }
    }
</script>