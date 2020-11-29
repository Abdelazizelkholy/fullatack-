import Vue from 'vue'
import VueRouter from "vue-router";

Vue.use(VueRouter)
import firstPage from './compontents/pages/firstpage'
import secondPage from './compontents/pages/secandpage'
import Hooks from './compontents/pages/basic/hooks'
import methods from './compontents/pages/basic/methods'

////////  project //////////////
import home from './compontents/pages/home'
import tags from './admin/pages/tags'
import category from './admin/pages/category'

const routes = [
    //  project route
    {
        path: '/',
        component: home,
    },
    {
        path: '/tags',
        component: tags,
    },
    {
        path: '/category',
        component: category,
    },


    // basic tutorial route

    {
        path: '/my-new-vue-router',
        component: firstPage,
    },
    {
        path: '/my-router',
        component: secondPage,
    },
    // vue hooks
    {
        path: '/hooks',
        component: Hooks,
    },
    // more basic
    {
        path: '/methods',
        component: methods,
    }
]

export default new VueRouter({
    mode: 'history',
    routes

})