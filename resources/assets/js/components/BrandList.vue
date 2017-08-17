<template>
    <div>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
        <div class="text-right">
            <!--Open User Creating Modal-->
            <!--<router-link :to="{ name: 'create-product' }" class="btn btn-primary mb-xs-10">+ New Product</router-link>-->
            <button class="btn btn-primary" @click.stop="triggerBrandForm">+ New Brand</button>
        </div>
        <div class="row">
            <!--main-->
            <div class="col-md-12">
                <table class="table brand-table">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Name</td>
                            <td>Slug</td>
                            <td>Logo</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="b in brands">
                            <td>{{b.id}}</td>
                            <td>
                                <a href="#" target="_blank">{{b.name}}</a>
                            </td>
                            <td>
                                <a href="#" target="_blank">{{b.slug}}</a>
                            </td>
                            <td>
                                <img :src="b.logo.url" class="brand-logo" :alt="b.logo.name" v-if="b.logo">
                            </td>
                            <td>
                                <!--<router-link :to="{ name: 'edit-brand', params: { brandId: b.id } }" class="btn btn-primary mb-xs-10">Edit</router-link>-->
                                <a href="#" class="btn btn-primary" @click.prevent="triggerBrandForm(b.id)">Edit</a>
                                <a href="#" class="btn btn-danger">x Delete</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!--edit user modal-->
        <modal :show.sync="modals.showBrandForm" @ok="submitBrand" @cancel="discardBrand">
            <div slot="header">Create Brand</div>
            <div slot="title">Create Brand</div>
            <div>
                <form @submit.prevent="submitBrand">
                    <div class="form-group">
                        <label for="brandname" class="label-control">Name</label>
                        <input type="text" name="brandname" class="form-control" v-model="brand.name">
                    </div>
                    <div class="form-group">
                        <label for="slug" class="label-control">Slug</label>
                        <input type="text" name="slug" class="form-control" v-model="brand.slug">
                    </div>
                    <div class="form-group">
                        <ImagesList v-bind:selected-image-id="brand.logo_id" v-model="brand.logo_id" type="single"></ImagesList>
                    </div>
                    <div class="form-group">
                        <label for="desc" class="label-control">Short Description</label>
                        <textarea type="text" name="desc" class="form-control editor" v-model="brand.description_md"></textarea>
                    </div>
                </form>
            </div>
            <div slot="footer">
                <button class="btn btn-primary" type="submit" v-if="mode == 'create'" @click="createBrand">Create</button>
                <button class="btn btn-primary" type="submit" v-if="mode == 'edit'" @click="updateBrand">Save</button>
                <button class="btn btn-default" @click="discardBrand">Cancel</button>
            </div>
        </modal>
    </div>
</template>
<script>
    export default {
        mounted() {
            console.log('Product List ready.');
            this.editor = new simplemde({
                element: document.querySelector(".editor")
            });
        },
        created() {
            // fetch the data when the view is created and the data is
            // already being observed
            this.fetchBrands();
        },
        components: {
            Modal,
            ImagesList
        },
        data() {
            return {
                loading: false,
                error: null,
                editor: null,
                modals: {
                    showBrandForm: false,
                },
                mode: 'create',
                api: this.$root.$data.api,
                brands: [],
                editingBrandIndex: -1,
                brand: {
                    name: '',
                    logo_id: '',
                    description_md: '',
                    slug: '',
                }
            };
        },
        methods: {
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

            submitBrand() {
                switch (this.mode) {
                    case 'create':
                        this.createBrand();
                        break;
                    case 'edit':
                    default:
                        this.updateBrand();
                        break;
                }
            },

            updateBrand() {
                this.brand.description_md = this.editor.value();
                axios.put(this.api.updateBrand + this.brand.id, this.brand)
                    .then((res) => {
                        var editingBrandIndex = _.findIndex(this.brands, { id: res.data.updatedItem.id });
                        this.brands[editingBrandIndex] = res.data.updatedItem;
                        this.discardBrand();
                        swal('Bravo', 'Brand has been updated', 'success');
                    })
                    .catch((error) => {
                        swal('Uh oh', 'Something went wrong, brand not updated', 'error');
                    });
            },

            createBrand() {
                this.brand.description_md = this.editor.value();
                axios.post(this.api.createBrand, this.brand)
                    .then((res) => {
                        this.brands.push(res.data.brand);
                        this.discardBrand();
                        swal('Bravo', 'Brand has been added', 'success');
                    })
                    .catch((error) => {
                        swal('Uh oh', 'Something went wrong, brand not added', 'error');
                    });
            },

            discardBrand() {
                this.brand = {
                    name: '',
                    logo_id: '',
                    description_md: '',
                    slug: '',
                };
                this.editingBrandIndex = -1;
                this.triggerBrandForm();
            },

            triggerBrandForm(brandId) {
                if (typeof (brandId) == 'number') {
                    // make a copy
                    this.brand = _.assign({}, _.find(this.brands, {
                        id: brandId
                    }));
                    this.mode = 'edit';
                } else {
                    this.mode = 'create';
                }
                this.modals.showBrandForm = !this.modals.showBrandForm;
                setTimeout(this.editor.value(this.brand.description_md), 1000);
            },
        }
    }
</script>