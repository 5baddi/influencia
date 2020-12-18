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
import jQuery from 'jquery';
import VueTimeago from 'vue-timeago';

Vue.prototype.$http = api;

// Init JQuery
window.jQuery = window.$ = jQuery

// Use plugins
Vue.use(abilitiesPlugin, ability);
Vue.use(VueTimeago, {
    name: 'Timeago', // Component name, `Timeago` by default
    locale: 'en',
});

// Register global component
Vue.component('DataTable', DataTable);
Vue.component('ConfirmationModal', ConfirmationModal);

// Stylesheet
import '@fortawesome/fontawesome-free/css/all.css'
import '@fortawesome/fontawesome-free/js/all.js'

const app = new Vue({
    el: '#app',
    components: { App },
    store,
    router,
    watch: {
        $route: {
            handler(){
                api.get("/api/abilities").then(response => {
                    if(typeof response.data.content !== 'undefined'){
                        ability.update(response.data.content);
                    }
                }).catch(error => {});

                // Refresh user and active brand
                if(typeof this.$store.getters.AuthenticatedUser === "object" && this.$store.getters.AuthenticatedUser !== null){
                    // Refresh User
                    this.$store.dispatch("fetchUser", this.$store.getters.AuthenticatedUser.uuid)
                        .then(() => {
                            // Re-set active brand
                            this.$store.dispatch("setActiveBrand")
                                .catch(error => {});
                        })
                        .catch(error => {});
                }
            },
            immediate: true
        }
    },
    created() {
        setupInterceptors(store);

        api.interceptors.response.use(response => {
                return Promise.resolve(response);
            }, error => {
                // if(error.response.status === 401){
                //     this.$store.dispatch('logout').then(() => this.$router.push({ name: "login" }).catch(()=>{}))
                // }
                if(error.response.status === 429){
                    console.log("Too many requests!");
                }

                return Promise.reject(error);
            }
        );

        this.$router.beforeEach((to, from, next) => {
            const loggedIn = this.$store.getters.isLogged && localStorage.getItem('user');

            // let vm = this;
            // if(!to.matched.some(record => (typeof record.meta.subject === "undefined") ? true : vm.$store.getters.AuthenticatedUser !== null && (vm.$store.getters.AuthenticatedUser.is_superadmin || vm.$can('list', record.meta.subject)))){
            //     next('/')
            // }

            if(to.matched.some(record => record.meta.auth) && !loggedIn){
                next('/login');
            }

            next();
        });
    }
});
