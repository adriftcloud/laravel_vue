import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const router = new VueRouter({
    routes: [
        {path: '/', redirect: '/invoices'},
        {path: '/invoices', component: require('../views/invooces/index.vue')},
        {path: '/invoices/create', component: require('../views/invooces/form.vue')},
        {path: '/invoices/:id/edit', component: require('../views/invooces/form.vue'), meta: {mode: 'edit'}},
        {path: '/invoices/:id', component: require('../views/invooces/show.vue')}
    ]
})

export default router