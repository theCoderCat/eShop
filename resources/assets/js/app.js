/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

$('document').ready(function () {
    $(function () {
        $(".preloader").fadeOut();
        $('#side-menu').metisMenu();
    });
});

/* Define components */
const Home = require('./components/Home.vue');
const ProductForm = require('./components/ProductForm.vue');
const ProductList = require('./components/ProductList.vue');
const BrandList = require('./components/BrandList.vue');
/* Define components - END */

const routes = [{
    name: 'home',
    path: '/',
    component: Home
}, {
    name: 'product-list',
    path: '/product',
    component: ProductList
}, {
    name: 'create-product',
    path: '/product/new',
    component: ProductForm,
    props: {
        mode: "create"
    }
}, {
    name: 'edit-product',
    path: '/product/edit/:productId',
    component: ProductForm,
    props: (route) => ({
        productId: route.params.productId,
        mode: "edit"
    })
},{
    name: 'brands',
    path: '/brands',
    component: BrandList,
}];

import VueRouter from 'vue-router';
Vue.use(VueRouter);
window.router = new VueRouter({
    routes
});

const sidebarLinks = [{
    title: 'Home',
    routeName: 'home',
}, {
    title: 'Product',
    routeName: 'product-list',
}, {
    title: 'Brand',
    routeName: 'brands',
}];

const api = {
    'getAllCategories': 'categories',
    'createCategory': 'category/create',
    'uploadFile': 'file/upload',
    'createProduct': 'product/create',
    'getAllImages': 'files/type/image',
    'uploadNewImage': 'file/upload',
    'createTag': 'tag/create',
    'getAllTags': 'tags',
    'getProductById': 'product/id',
    'updateProduct': 'product/update',
    'getAllBrands': 'brands',
    'createBrand': 'brands/store',
    'updateBrand': 'brands/update',
    'getAllProducts': 'products'
};

var App = new Vue({
    router,
    data: () => {
        return {
            sidebarLinks: sidebarLinks,
            api: api,
        };
    }
}).$mount('#app');