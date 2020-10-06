import Vue from 'vue'
import VueRouter from 'vue-router'


import LoginPage from "./pages/LoginPage";
import DashboardContainer from "./pages/DashboardContainer";
import DashboardPage from "./pages/DashboardPage";
import CampaignsPage from "./pages/CampaignsPage";
import SearchPage from "./pages/SearchPage";
import TrackersPage from "./pages/TrackersPage";
import BrandsPage from "./pages/BrandsPage";
import UsersPage from "./pages/UsersPage";
import SettingsPage from "./pages/SettingsPage";
import InfluencersPage from "./pages/InfluencersPage";

Vue.use(VueRouter)

const routes = [
    {

        path: '/',
        component: DashboardContainer,
        redirect: {
            name: 'dashboard'
        },
        meta: {
            auth: true
        },
        children: [
            {
                name: 'search',
                path: '/search',
                component: SearchPage,
                meta: {
                    auth: true
                },

            },
            {
                name: 'trackers',
                path: '/trackers',
                component: TrackersPage,
                meta: {
                    auth: true
                },

            },
            {
                name: 'brands',
                path: '/brands',
                component: BrandsPage,
                meta: {
                    auth: true
                },

            },
            {
                name: 'dashboard',
                path: '/dashboard',
                component: DashboardPage,
                meta: {
                    auth: true
                },

            },
            {
                name: 'campagins',
                path: '/campaigns/:uuid?',
                component: CampaignsPage,
                meta: {
                    auth: true
                },
            },
            {
                name: 'users',
                path: '/users',
                component: UsersPage,
                meta: {
                    auth: true
                },

            },
            {
                name: 'settings',
                path: '/settings',
                component: SettingsPage,
                meta: {
                    auth: true
                },

            },
            {
                name: 'influencers',
                path: '/influencers/:uuid?',
                component: InfluencersPage,
                meta: {
                    auth: true
                },

            }
        ]
    },
    {
        name: 'login',
        path: '/login',
        component: LoginPage,
    }
]

export const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
})
