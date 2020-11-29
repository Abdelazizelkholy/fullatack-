require('./bootstrap');
window.Vue = require('vue');
import router from "./router";
import iView from 'iview';
import 'iview/dist/styles/iview.css';
import common from './common';

Vue.use(iView);
Vue.mixin(common)

Vue.component('mainapp', require('./compontents/mainapp').default)
const app = new Vue({
    el: '#app',
    router
});
