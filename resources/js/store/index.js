
import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import { api } from '../api'
Vue.use(Vuex);

function fatchLocalUser() {
    if (localStorage.getItem("user")) {
        const user = JSON.parse(localStorage.getItem("user"));
        api.defaults.headers.common.Authorization = `Bearer ${user.token}`
        return user;
    }
    return null;
}

const state = () => ({
    user: fatchLocalUser(),
    brands: null,
    activeBrand: null,
    users: null,
    campaigns: null,
    trackers: null
})

const getters = {
    AuthenticatedUser: state => state.user && state.user.user,
    Token: state => state.user.token,
    isLogged: state => !!state.user,
    isAdmin: state => state.user && state.user.user.role == 'SUPER_ADMIN',
    brands: state => state.brands,
    users: state => state.users,
    campaigns: state => state.campaigns,
    trackers: state => state.trackers,
    activeBrand: state => state.activeBrand
};

const actions = {
    login({ commit, state }, credentials) {

        return new Promise((resolve, reject) => {
            api.post('/login', credentials).then((response) => {
                localStorage.setItem("user", JSON.stringify(response.data))
                commit('setUser', { user: response.data })
                api.defaults.headers.common.Authorization = `Bearer ${response.data.token}`
                resolve(response)
            }).catch(error => reject(error))
        })
    },
    logout({ commit }) {
        return new Promise((resolve, reject) => {
            localStorage.removeItem("user")
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
            api.get("/api/users").then(response => {
                commit('setUsers', { users: response.data })
                resolve(response)
            }).catch(response => reject(response))
        });
    },
    addNewUser({ commit, state }, data) {
        return new Promise((resolve, reject) => {
            api.post("/api/register", data)
                .then(response => {
                    commit('setNewUser', { user: response.data })
                    resolve(response)
                }).catch(error => {
                    reject(error)
                })
        })
    },
    fetchBrands({ commit, state }) {
        return new Promise((resolve, reject) => {
            api.get("/api/brands").then(response => {
                //state.brands = response.data
                commit('setBrands', { brands: response.data })
                resolve(response)
            }).catch(response => reject(response))
        });
    },
    addBrand({ commit, state }, data) {
        return new Promise((resolve, reject) => {
            api.post("/api/brands", data, {
                headers: {
                    "Content-Type": "multipart/form-data"
                }
            })
                .then(response => {
                    commit('setBrand', { brand: response.data })
                    resolve(response)
                })
                .catch(response => {
                    reject(response)
                })
        })
    },
    addNewCampaign({ commit, state }, data) {
        return new Promise((resolve, reject) => {
            api.post("/api/campaigns", data)
                .then(response => {
                    commit('setNewCampaign', { campaign: response.data })
                    resolve(response)
                })
                .catch(response => {
                    reject(response)
                })
        })
    },
    addNewTracker({ commit, state }, data) {
        return new Promise((resolve, reject) => {
            let isStory = data.type === "story";

            api.post("/api/trackers" + (isStory ? "/story" : ""), data)
                .then(response => {
                    commit('setNewTracker', { tracker: response.data })
                    resolve(response)
                })
                .catch(response => {
                    reject(response)
                })
        })
    },
    setActiveBrand({ commit, state }, brand) {
        commit("setActiveBrand", { brand })
    },
    fetchCampaigns({ commit, state }) {
        return new Promise((resolve, reject) => {
            if (state.activeBrand) {
                api.get(`/api/campaigns/${state.activeBrand.uuid}`)
                    .then((response) => {
                        commit('setCampaigns', { campaigns: response.data })
                        resolve(response);
                    })
                    .catch((error) => {
                        reject(error)
                    })
            }

        });
    },
    fetchTrackers({ commit, state }) {
        return new Promise((resolve, reject) => {
            if (state.activeBrand) {
                api.get(`/api/brand/${state.activeBrand.uuid}/trackers`)
                    .then((response) => {
                        commit('setTrackers', { trackers: response.data })
                        resolve(response);
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
                if(item.id == state.user.user.selected_brand_id) {
                    brand = item
                }
            });
            // console.log(brand);
        }
        state.activeBrand = brand
    },
    setNewCampaign: (state, { campaign }) => {
        if (!state.campaigns) {
            state.campaigns = [];
        }
        state.campaigns.push(campaign)
        // console.log("%%%%%%%%%%%%%%")
        // console.log(campaign)
        // console.log("%%%%%%%%%%%%%%")
    },
    setNewTracker: (state, { tracker }) => {
        if(!state.trackers){
            state.trackers = [];
        }
        state.trackers.push(tracker);
    },
    setCampaigns: (state, { campaigns }) => {
        state.campaigns = campaigns;
    },
    setTrackers: (state, { trackers }) => {
        state.trackers = trackers;
    }
}


export default new Vuex.Store({
    state,
    getters,
    actions,
    mutations
});