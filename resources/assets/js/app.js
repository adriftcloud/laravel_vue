import Vue from 'vue'
import App from './App.vue'
import router from './router'
import swal from 'sweetalert2'
import bar from './components/progress'

router.beforeEach((to, from, next) => {
    bar.start()
    next()
})

Vue.filter('formatMoney', (value) => {
    return Number(value)
        .toFixed(2)
        .replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
})

const swalPlugin = {}

swalPlugin.install = function (Vue) {
    swal.setDefaults({
        confirmButtonClass: 'btn btn-primary',
        cancelButtonClass: 'btn btn-default',
        buttonsStyling: false,
        showCloseButton: true
    });
    Vue.prototype.$swal = swal;
}

Vue.use(swalPlugin)

const app = new Vue({
    el: '#root',
    render: h => h(App),
    router
})