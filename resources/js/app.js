/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vue from 'vue';
import { router } from './routes';
import store from './store';
import App from './pages/App';
import { api } from './api/index';
import { setupInterceptors } from './api/httpInterceptors';
import './notifications';
import { abilitiesPlugin } from '@casl/vue';
import ability from './services/ability';
import DataTable from './components/DataTable.vue';
import ConfirmationModal from "./components/modals/ConfirmationModal";
import VueTimeago from 'vue-timeago';
import './services/filters';
import SecureLS from "secure-ls";
import VueNumeric from 'vue-numeric';

Vue.prototype.$http = api;

// Use plugins
Vue.use(abilitiesPlugin, ability);
Vue.use(VueTimeago, {
    name: 'Timeago', // Component name, `Timeago` by default
    locale: 'en',
});

// Register global component
Vue.component('DataTable', DataTable);
Vue.component('ConfirmationModal', ConfirmationModal);
Vue.component('VueNumeric', VueNumeric);

// Stylesheet
import '@fortawesome/fontawesome-free/css/all.css';
import '@fortawesome/fontawesome-free/js/all.js';

// Routes auth validation
router.beforeEach((to, from, next) => {
    if(to.matched.some(route => route.meta.auth)){
        let ls = new SecureLS();
        let loggedIn = store.getters.isLogged && ls.get("user");
        if(!loggedIn){
            next({ name: 'login' });
        }
    }

    next();
});

const app = new Vue({
    el: '#app',
    components: { App },
    store,
    router,
    created() {
        setupInterceptors(store);
    }
});
