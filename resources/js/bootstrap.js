import Vue from 'vue';
import jQuery from 'jquery';
import 'bootstrap'

import Toasted from 'vue-toasted';
import DataTable from 'laravel-vue-datatable';
import axios from 'axios'

Vue.use(DataTable);

window.axios = axios;

Vue.mixin({
    methods: {
        route: window.route
    }
});

Vue.use(Toasted, {
    duration: 2000,
    position: 'bottom-right',
    theme: 'bubble',
});


// Lets not use axios directly
Object.defineProperties(Vue.prototype, {
    $http: {
        get: function () {
            return axios
        }
    }
});

let token = document.head.querySelector('meta[name="csrf-token"]');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;

import 'jquery.easing';
import 'startbootstrap-sb-admin-2/js/sb-admin-2'
