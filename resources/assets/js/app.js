import Vue from 'vue';
// whole page js code
import App from './App.vue';
// vue router
import VueRouter from 'vue-router';
// elements-ui
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
// vue resourece
import VueResource from 'vue-resource';
import Booklet from 'vue-booklet';

import { myMixin } from './common.js';
Vue.mixin(myMixin);

// vuex
/**
 * import vue-router
 */
Vue.use(VueRouter);
// use element ui
Vue.use(ElementUI);
// use vue resource 
Vue.use(VueResource);

Vue.use(Booklet);

import { routes } from './router.js';

import { store } from './store.js';

const router = new VueRouter({
routes});

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

new Vue({
  el: '#app',
  mode: 'history',
  router,
  store,
  beforeCreate() {
    
  },
  render: h => h(App)
});
