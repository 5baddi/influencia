import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

const routes = [
    {

        path: '/',
        component: () => import("./pages/DashboardContainer"),
        redirect: {
            name: 'dashboard'
        },
        meta: {
            auth: true
        },
        children: [
            {
                name: 'Not found',
                path: '/404',
                component: () => import("./components/partials/404"),
            },
            {
                name: 'Internal server error',
                path: '/error',
                component: () => import("./components/partials/Error"),
            },
            {
                name: 'search',
                path: '/search',
                component: () => import("./pages/SearchPage"),
                meta: {
                    auth: true
                },

            },
            {
                name: 'trackers',
                path: '/trackers/:uuid?',
                component: () => import("./pages/TrackersPage"),
                meta: {
                    auth: true,
                    // subject: 'tracker'
                },
            },
            {
                name: 'brands',
                path: '/brands',
                component: () => import("./pages/BrandsPage"),
                meta: {
                    auth: true,
                    actions: ['list'],
                    subject: 'brand'
                },

            },
            {
                name: 'dashboard',
                path: '/dashboard',
                component: () => import("./pages/DashboardPage"),
                meta: {
                    auth: true
                },

            },
            {
                name: 'campaigns',
                path: '/campaigns/:uuid?',
                component: () => import("./pages/CampaignsPage"),
                meta: {
                    auth: true
                },
            },
            {
                name: 'users',
                path: '/users',
                component: () => import("./pages/UsersPage"),
                meta: {
                    auth: true
                },

            },
            {
                name: 'roles',
                path: '/roles',
                component: () => import("./pages/RolesPage"),
                meta: {
                    auth: true
                },

            },
            {
                name: 'settings',
                path: '/settings',
                component: () => import("./pages/SettingsPage"),
                meta: {
                    auth: true
                },

            },
            {
                name: 'influencers',
                path: '/influencers/:uuid?',
                component: () => import("./pages/InfluencersPage"),
                meta: {
                    auth: true
                },

            }
        ]
    },
    {
        name: 'login',
        path: '/login',
        component: () => import("./pages/LoginPage"),
    }
];

export const router = new VueRouter({
    mode: 'history',
    routes: routes
});
