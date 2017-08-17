<template>
    <div>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
        <div class="text-right">
            <!--Open User Creating Modal-->
            <button class="btn btn-primary mb-xs-10" v-if="mode == 'create'" @click="createProduct">Publish</button>
            <button class="btn btn-primary mb-xs-10" v-if="mode == 'edit'" @click="updateProduct">Save</button>
        </div>
        <div class="row">
            <!--main-->
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">New Product</div>
                    <div class="panel-body">
                        <form action="" @submit.prevent="">
                            <div class="row">
                                <div class="form-group col-sm-6">
                                <label for="" class="label-control">Name</label>
                                <input type="text" class="form-control" v-model="product.name">
                            </div>

                            <div class="form-group col-sm-6">
                                <label for="" class="label-control">Slug</label>
                                <input type="text" class="form-control" v-model="product.slug">
                            </div>
                            </div>
                            
                            <div class="row">
                                <div class="form-group col-sm-6">
                                <label for="" class="label-control">Price</label>
                                <input type="number" class="form-control" v-model="product.price">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="" class="label-control">In stock</label>
                                <input type="number" class="form-control" v-model="product.in_stock">
                            </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="label-control">Content</label>
                                <textarea class="form-control" v-model="product.description_md" id="editor"></textarea>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!--side-->
            <div class="col-md-4">
                <!---->
                <div class="form-group">
                    <label for="" class="label-control">Brands</label>

                    <div class="input-group xs-mb-15">
                        <select class="form-control" v-model="product.brand_id">
                            <option v-for="b in brands" :value="b.id">{{b.name}}</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="label-control">Category</label>

                    <div class="input-group xs-mb-15">
                        <select class="form-control" v-model="product.category_id">
                            <option v-for="c in categories" :value="c.id">{{c.name}}</option>
                        </select>
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-primary" @click="triggerCreateCategory">+</button>
                        </span>
                    </div>

                </div>

                <div class="form-group xs-mb-15">
                    <label for="" class="label-control">Tags</label>
                    <label class="custom-control custom-checkbox" v-for="tag in tags">
                        <input type="checkbox" class="custom-control-input" :value="tag.sanitized" v-model="product.tags">
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">{{tag.name}}</span>
                    </label>
                    <form action="" v-on:submit.prevent="createTag">
                        <input type="text" class="form-control" v-model="newTag.name">
                    </form>
                </div>

                <div class="form-group">
                    <label for="product-featured-img" class="label-control">Featured Image</label>
                    <ImagesList v-bind:selected-image-id="product.featured_image_id" v-model="product.featured_image_id" type="single"></ImagesList>
                </div>

                <label for="product-img" class="label-control">Product Images</label>
                <ImagesList v-bind:selected-image-id="product.images" v-model="product.images" type="multiple"></ImagesList>
            </div>
        </div>

        <!--edit user modal-->
        <modal :show.sync="modals.showCreateCategory" @ok="createCategory" @cancel="discardCategory">
            <div slot="header">Create category</div>
            <div slot="title">Create category</div>
            <div>
                <form @submit.prevent="save">
                    <div class="form-group">
                        <label for="username" class="label-control">Name</label>
                        <input type="text" name="username" class="form-control" v-model="newCat.name">
                    </div>
                    <div class="form-group">
                        <label for="username" class="label-control">Category Icon</label>
                        <ImagesList v-bind:selected-image-id="newCat.icon_id" v-model="newCat.icon_id" type="single"></ImagesList>
                    </div>
                    <div class="form-group">
                        <label for="desc" class="label-control">Short Description</label>
                        <textarea type="text" name="desc" class="form-control" v-model="newCat.description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="slug" class="label-control">Slug</label>
                        <input type="text" name="slug" class="form-control" v-model="newCat.slug">
                    </div>
                </form>
            </div>
            <div slot="footer">
                <button class="btn btn-primary" type="submit" @click="createCategory">Save</button>
                <button class="btn btn-default" @click="discardCategory">Cancel</button>
            </div>
        </modal>
    </div>
</template>
<script>
    export default {
        mounted() {
            console.log('Product Form ready.');
            this.postEditor = new simplemde({
                element: document.getElementById("editor")
            });
            if (this.product.translated) {
                this.translateEditor = new simplemde({
                    element: document.getElementById("translate-editor")
                });
            }
        },
        created() {
            // fetch the data when the view is created and the data is
            // already being observed
            this.fetchCategories();
            this.fetchTags();
            this.fetchImages();
            this.fetchBrands();
            if (this.mode === 'edit') this.fetchProduct();
        },
        components: {
            Modal,
            ImagesList
        },
        props: ['mode', 'productId'],
        data() {
            return {
                loading: false,
                error: null,
                modals: {
                    showCreateCategory: false,
                },
                api: this.$root.$data.api,
                postEditor: null,
                //                translateEditor: null,
                categories: [],
                tags: [],
                brands: [],
                images: [],
                newImg: null,
                newTag: {
                    name: ""
                },
                product: {
                    name: '',
                    description_md: '',
                    category_id: '',
                    featured_image_id: '',
                    images: [],
                    brand_id: '',
                    tags: [],
                    slug: '',
                    price: '',
                    in_stock: '',
                    featured: false
                },
                newCat: {
                    name: '',
                    icon_id: '',
                    slug: '',
                    description: '',
                }
            };
        },
        methods: {
            fetchProduct() {
                axios.get(this.api.getProductById + '/' + this.productId)
                    .then((res) => {
                        // success
                        this.product = res.data.product;
                        this.postEditor.value(this.product.description_md);
                    })
                    .catch((error) => {
                        //
                        console.log(error);
                        swal('Fail', 'Cannot fetch product', 'error');
                    });
            },
            fetchCategories() {
                //
                axios.get(this.api.getAllCategories)
                    .then((res) => {
                        // success
                        this.categories = res.data.allItems;
                    })
                    .catch((error) => {
                        //
                        console.log(error);
                        alert('cannot fetch categories');
                    });
            },
            fetchBrands() {
                //
                axios.get(this.api.getAllBrands)
                    .then((res) => {
                        // success
                        this.brands = res.data.allItems;
                    })
                    .catch((error) => {
                        //
                        console.log(error);
                        alert('cannot fetch brands');
                    });
            },
            fetchImages() {
                // get all images
                axios.get(this.api.getAllImages)
                    .then((res) => {
                        // success
                        this.images = res.data.files;
                    })
                    .catch((error) => {
                        //
                        console.log(error);
                        alert('cannot fetch images');
                    });
            },
            fetchTags() {
                // get all images
                axios.get(this.api.getAllTags)
                    .then((res) => {
                        // success
                        this.tags = res.data.allItems;
                    })
                    .catch((error) => {
                        //
                        console.log(error);
                        alert('cannot fetch tags');
                    });
            },
//            triggerNewImgInput() {
//                $('.new-img-input').trigger('click');
//            },
//            uploadImage(callback) {
//                // get image data
//                let data = new FormData();
//                data.append('img', document.querySelector('.new-img-input').files[0]);
//                axios.post(this.api.uploadNewImage, data)
//                    .then((res) => {
//                        // success
//                        this.images.push(res.data.file);
//                        console.log(res);
//                        if (typeof (callback) == 'function') {
//                            callback();
//                        }
//                    })
//                    .catch((error) => {
//                        //
//                        console.log(error);
//                    });
//            },
            triggerCreateCategory() {
                this.modals.showCreateCategory = !this.modals.showCreateCategory;
            },
            createCategory() {
                // send new category information to server
                axios.post(this.api.createCategory, this.newCat).then((res) => {
                    // success
                    if (res.data.success) {
                        // if success, append new category to categories array
                        this.categories.push(res.data.newItem);
                        // select new category as post category
                        this.product.category_id = res.data.newItem.id;
                        this.triggerCreateCategory();
                    } else {}
                }).catch((error) => {
                    // error
                    console.log(error);
                    alert('Network error');
                });
            },
            discardCategory() {
                this.newCat = {
                    name: '',
                    icon_id: '',
                    slug: '',
                    description: '',
                };
                this.triggerCreateCategory();
            },
            createTag() {
                axios.post(this.api.createTag, this.newTag)
                    .then((res) => {
                        // success
                        this.tags.push(res.data.newItem);
                        this.product.tags.push(res.data.newItem.sanitized);
                        this.newTag.name = "";
                    })
                    .catch((error) => {
                        //
                        console.log(error);
                        alert('cannot create tags, please check if it\'s existing ');
                    });
            },
            toggleTag(name) {
                if (_.indexOf(this.product.tags, name) != -1) {
                    delete(this.product.tags[_.indexOf(this.product.tags, name)]);
                } else {
                    this.product.tags.push(name);
                }
            },
            createProduct() {
                if (!this.validatePost()) return;
                this.product.description_md = this.postEditor.value();
                axios.post(this.api.createProduct, this.product)
                    .then((res) => {
                        // success
                        if (res.data.success) {
                            this.product = res.data.newItem;
                            router.push({
                                name: 'edit-product',
                                params: {
                                    productId: this.product.id
                                }
                            });
                            swal('Bravo', 'product has been created successfully', 'success');
                        } else {
                            swal('Fail', 'Something went wrong, post not saved', 'error');
                        }
                    })
                    .catch((error) => {
                        // error
                        alert('Network error');
                    });
            },
            updateProduct() {
                if (!this.validatePost()) return;
                this.product.description_md = this.postEditor.value();
                axios.post(this.api.updateProduct + this.productId, this.product)
                    .then((res) => {
                        // success
                        if (res.data.success) {
                            swal('Bravo', 'product has been saved successfully', 'success');
                            this.product = res.data.updatedItem;
                        } else {
                            swal('Fail', 'Something went wrong, post not saved', 'error');
                        }
                    })
                    .catch((error) => {
                        // error
                        alert('Network error');
                    });
            },
            validatePost() {
                return true;
            }
        }
    }
</script>