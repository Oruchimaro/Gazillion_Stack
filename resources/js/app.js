
require('./bootstrap');

window.Vue = require('vue');

import VueIziToast from 'vue-izitoast';

import 'izitoast/dist/css/iziToast.css';

// import 'izitoast/dist/css/iziToast.min.css';

Vue.use(VueIziToast);

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('user-info', require('./components/UserInfo.vue').default);
Vue.component('answer', require('./components/Answer.vue').default);



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
