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
const ArticleForm = require('./components/ArticleForm.vue');
const ArticleList = require('./components/ArticleList.vue');
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
}, {
    name: 'brands',
    path: '/brands',
    component: BrandList,
}, {
    name: 'create-article',
    path: '/article/new',
    component: ArticleForm,
    props: {
        mode: "create"
    }
}, {
    name: 'article-list',
    path: '/article/',
    component: ArticleList,
}, {
    name: 'edit-article',
    path: '/article/:articleId',
    component: ArticleForm,
    props: (route) => ({
        articleId: route.params.articleId,
        mode: "edit"
    })
}];

import VueRouter from 'vue-router';

Vue.use(VueRouter);
window.router = new VueRouter({
    routes,
    linkExactActiveClass: 'active',
    base: '/'
});

const sidebarLinks = [
    {
        title: "Product Management",
        routeName: false,
        isActive: true,
        submenu: [
            {
                title: 'Product',
                routeName: 'product-list',
            }, {
                title: 'Brand',
                routeName: 'brands',
            }
        ]
    },{
        title: "Article Management",
        routeName: false,
        isActive: false,
        submenu: [
            {
                title: 'Articles',
                routeName: 'article-list',
            }, {
                title: 'Create',
                routeName: 'create-article',
            }
        ]
    },
    // {
    //     title: "Store Information",
    //     routeName: false,
    //     isActive: false,
    //     submenu: [],
    // }
];

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
    'updateProduct': 'product/update/',
    'getAllBrands': 'brands',
    'createBrand': 'brands/store',
    'updateBrand': 'brands/update/',
    'getAllProducts': 'products',
    'createArticle': 'articles/store',
    'updateArticle': 'articles/update',
    'getAllArticles': 'articles',
    'getArticleById': 'articles/id',
    'getAllArticleCategories': 'article-categories/',
    'createArticleCategory': 'article-categories/store',
};

var App = new Vue({
    router,
    data: () => {
        return {
            sidebarLinks: sidebarLinks,
            api: api,
        };
    },

    methods: {
        toggleSubmenu: function (index) {
            let _this = this;
            if (this.sidebarLinks[index].isActive) {
                this.sidebarLinks[index].isActive = false;
            } else {
                let currentActiveIndex = _.findIndex(this.sidebarLinks, function (o) {
                    return o.isActive
                });
                if (currentActiveIndex !== -1) {
                    this.sidebarLinks[currentActiveIndex].isActive = false;
                }
                this.sidebarLinks[index].isActive = true;
            }
        }
    }
}).$mount('#app');