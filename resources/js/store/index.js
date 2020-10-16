
import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';
import { api } from '../api';
import { Loader } from './loader';
import ability from '../services/ability';

Vue.use(Vuex);

function fatchLocalUser() {
    if (localStorage.getItem("user") && localStorage.getItem("user") !== 'undefined') {
        const user = JSON.parse(localStorage.getItem("user"));
        api.defaults.headers.common.Authorization = `Bearer ${user.token}`;

        return user;
    }

    return null;
}

const state = () => ({
    user: fatchLocalUser(),
    brands: null,
    activeBrand: null,
    users: null,
    campaigns: {all: []},
    campaign: null,
    trackers: null,
    influencers: null,
    influencer: null
})

const getters = {
    AuthenticatedUser: state => state.user && state.user.user,
    Token: state => state.user.token,
    isLogged: state => !!state.user,
    isAdmin: state => state.user && state.user.user.role == 'SUPER_ADMIN',
    brands: state => state.brands,
    users: state => state.users,
    campaigns: state => state.campaigns,
    campaign: state => state.campaign,
    trackers: state => state.trackers,
    influencers: state => state.influencers,
    influencer: state => state.influencer,
    activeBrand: state => state.activeBrand
};

const actions = {
    login({ commit, state }, credentials) {

        return new Promise((resolve, reject) => {
            api.post('/login', credentials).then((response) => {
                localStorage.setItem("user", JSON.stringify(response))
                commit('setUser', { user: response })
                api.defaults.headers.common.Authorization = `Bearer ${response.token}`
                resolve(response)
            }).catch(error => reject(error))
        })
    },
    logout({ commit, state }) {
        return new Promise((resolve, reject) => {

            localStorage.removeItem("user")

            if (!state.isLogged) {
                commit('setUser', { user: null });
                resolve();
                return;
            }

            api.post('/api/logout')
                .then(() => {
                    commit('setUser', { user: null });
                    resolve();
                })
                .catch(error => reject(error))
        })

    },
    fetchUsers({ commit, state }) {
        return new Promise((resolve, reject) => {
            api.get("/api/v1/users").then(response => {
                commit('setUsers', { users: response.data.content })
                resolve(response.data)
            }).catch(response => reject(response))
        });
    },
    addNewUser({ commit, state }, data) {
        return new Promise((resolve, reject) => {
            api.post("/api/v1/users", data)
                .then(response => {
                    commit('setNewUser', { user: response.data.content })
                    resolve(response.data)
                }).catch(error => {
                    reject(error)
                })
        })
    },
    fetchInfluencers({ commit, state }) {
        return new Promise((resolve, reject) => {
            api.get("/api/v1/influencers").then(response => {
                commit('setInfluencers', { influencers: response.data.content })
                resolve(response.data)
            }).catch(response => reject(response))
        });
    },
    fetchInfluencer({ commit, state }, uuid) {
        return new Promise((resolve, reject) => {
            api.get("/api/v1/influencers/" + uuid).then(response => {
                commit('setInfluencer', { influencer: response.data.content })
                resolve(response.data)
            }).catch(response => reject(response))
        });
    },
    fetchBrands({ commit, state }) {
        return new Promise((resolve, reject) => {
            api.get("/api/v1/brands").then(response => {
                commit('setBrands', { brands: response.data.content })
                resolve(response.data)
            }).catch(response => reject(response))
        });
    },
    addBrand({ commit, state }, data) {
        return new Promise((resolve, reject) => {
            api.post("/api/v1/brands", data, {
                headers: {
                    "Content-Type": "multipart/form-data"
                }
            })
                .then(response => {
                    commit('setBrand', { brand: response.data.content })
                    resolve(response.data)
                })
                .catch(response => {
                    reject(response)
                })
        })
    },
    addNewCampaign({ commit, state }, data) {
        return new Promise((resolve, reject) => {
            api.post("/api/v1/campaigns", data)
                .then(response => {
                    commit('setNewCampaign', { campaign: response.data.content })
                    resolve(response.data)
                })
                .catch(response => {
                    reject(response)
                })
        })
    },
    addNewTracker({ commit, state }, data) {
        return new Promise((resolve, reject) => {
            // Verify is a story tracker
            let isStory = data.get('type') === "story";

            api.post("/api/v1/trackers" + (isStory ? "/story" : ""), data)
                .then(response => {
                    commit('setNewTracker', { tracker: response.data.content })
                    resolve(response.data)
                })
                .catch(error => {
                    reject(error)
                })
        })
    },
    setActiveBrand({ commit, state }, brand) {
        commit("setActiveBrand", { brand })
    },
    fetchCampaigns({ commit, state }) {
        return new Promise((resolve, reject) => {
            if (state.activeBrand) {
                api.get(`/api/v1/campaigns/${state.activeBrand.uuid}`)
                    .then((response) => {
                        commit('setCampaigns', { campaigns: response.data.content })
                        resolve(response.data);
                    })
                    .catch((error) => {
                        reject(error)
                    })
            }

        });
    },
    fetchCampaignAnalytics({ commit, state }, uuid) {
        return new Promise((resolve, reject) => {
            api.get("/api/v1/campaigns/" + uuid + "/analytics").then(response => {
                commit('setCampaign', { campaign: response.data.content })
                resolve(response.data)
            }).catch(response => reject(response))
        });
    },
    fetchTrackers({ commit, state }) {
        return new Promise((resolve, reject) => {
            if (state.activeBrand) {
                api.get(`/api/v1/brands/${state.activeBrand.uuid}/trackers`)
                    .then((response) => {
                        commit('setTrackers', { trackers: response.data.content })
                        resolve(response.data);
                    })
                    .catch((error) => {
                        reject(error)
                    })
            }

        });
    }
};

const mutations = {
    setUser: (state, { user }) => {
        state.user = user;
        if (user && state.user) axios.defaults.headers.common.Authorization = `Bearer ${state.user.token}`;
    },
    setUsers: (state, { users }) => {
        state.users = users
    },
    setBrand: (state, { brand }) => {
        if (!state.brands) {
            state.brands = [];
        }
        state.brands.push(brand)
    },
    setBrands: (state, { brands }) => {
        state.brands = brands
    },
    setInfluencers: (state, { influencers }) => {
        state.influencers = influencers
    },
    setInfluencer: (state, { influencer }) => {
        state.influencer = influencer
    },
    setNewUser: (state, { user }) => {
        if (!state.users) {
            state.users = [];
        }
        state.users.push(user)
    },
    setNewUser: (state, { user }) => {
        if (!state.users) {
            state.users = [];
        }
        state.users.push(user)
    },
    setActiveBrand: (state, { brand }) => {
        if (!brand) {
            state.brands.forEach((item, index) => {
                if (item.id == state.user.user.selected_brand_id) {
                    brand = item
                }
            });
            // console.log(brand);
        }
        state.activeBrand = brand
    },
    setNewCampaign: (state, { campaign }) => {
        if (!state.campaigns.all) {
            state.campaigns = {
                all: []
            };
        }

        state.campaigns.all.push(campaign);
    },
    setNewTracker: (state, { tracker }) => {
        if (!state.trackers) {
            state.trackers = [];
        }
        state.trackers.push(tracker);
    },
    setCampaigns: (state, { campaigns }) => {
        state.campaigns = campaigns;
    },
    setCampaign: (state, { campaign }) => {
        state.campaign = campaign;
    },
    setTrackers: (state, { trackers }) => {
        state.trackers = trackers;
    }
}

const updateAbilities = (store) => {
    return store.subscribe((actions) => {
        switch (actions.type) {
            case 'logout':
                ability.update([]);
            break
        }
    });
}

export default new Vuex.Store({
    state: state,
    getters: getters,
    actions: actions,
    mutations: mutations,
    modules: {
        Loader
    },
    plugins: [
        updateAbilities
    ]
});