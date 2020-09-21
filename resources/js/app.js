/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

//require('./bootstrap');

//window.Vue = require('vue');
import Vue from 'vue'
import { router } from './routes'
import store from './store'
import App from './pages/App'
import { api } from './api/index'
import './notifications'

// Stylesheet
import '@fortawesome/fontawesome-free/css/all.css'
import '@fortawesome/fontawesome-free/js/all.js'



Vue.prototype.$http = api;



const app = new Vue({
    el: '#app',
    components: { App },
    store,
    router,
    created() {
        api.interceptors.response.use(
            response => response,
            error => {
                if (error.response.status === 401) {
                    //localStorage.removeItem("user");
                    this.$store.dispatch('logout').then(() => this.$router.push({ name: "login" }))
                }
                return Promise.reject(error)
            }
        );
        this.$router.beforeEach((to, from, next) => {

            const loggedIn = !!this.$store.getters.isLogged && !!localStorage.getItem('user')


            if (to.matched.some(record => record.meta.auth) && !loggedIn) {
                next('/login')
                return
            }
            next()
        });
    }
});
