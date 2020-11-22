
import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';
import { api } from '../api';
import { Loader } from './loader';
import ability from '../services/ability';
import { reject } from 'lodash';

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
    token: null,
    dashboard: null,
    brands: null,
    activeBrand: null,
    users: null,
    campaigns: {all: []},
    campaign: null,
    trackers: null,
    influencers: null,
    influencer: null,
    roles: [],
})

const getters = {
    AuthenticatedUser: state => state.user,
    Token: state => state.token,
    isLogged: state => typeof state.user !== "undefined" && state.user !== null,
    isAdmin: state => state.user.is_superadmin,
    dashboard: state => state.dashboard,
    brands: state => state.brands,
    users: state => state.users,
    campaigns: state => state.campaigns,
    campaign: state => state.campaign,
    trackers: state => state.trackers,
    influencers: state => state.influencers,
    influencer: state => state.influencer,
    activeBrand: state => state.user && state.user.selected_brand ? state.user.selected_brand : state.activeBrand,
    roles: state => state.roles,
};

const actions = {
    login({ commit, state }, credentials) {

        return new Promise((resolve, reject) => {
            api.post('/oauth', credentials).then((response) => {
                let user = response.data.user;
                user.token = response.data.token;
                localStorage.setItem("user", JSON.stringify(user));

                commit('setUser', { user: response.data.user });
                commit('setToken', { token: response.data.token });

                api.defaults.headers.common.Authorization = `Bearer ${state.token}`;

                resolve(response.data);
            }).catch(error => reject(error));
        })
    },
    logout({ commit, state }) {
        return new Promise((resolve, reject) => {

            localStorage.removeItem("user");

            if (!state.isLogged) {
                commit('setUser', { user: null });
                commit('setUser', { token: null });
                resolve();
                return;
            }

            api.post('/api/logout')
                .then(() => {
                    commit('setUser', { user: null });
                    commit('setUser', { token: null });
                    resolve();
                })
                .catch(error => reject(error));
        })

    },
    fetchDashboard({commit, state}){
        return new Promise((resolve, reject) => {
            api.get('/api/v1/dashboard')
                .then(response => {
                    if(response.status === 201 && response.data.success){
                        commit('setDashboard', { dashboard: response.data.content });
                        resolve(response.data);
                    }else{
                        throw new Error("Something going wrong!");
                    }
                }).catch(error => {
                    reject(error);
                });
        });
    },
    fetchUser({ commit, state }, uuid) {
        return new Promise((resolve, reject) => {
            api.get("/api/v1/users/" + uuid).then(response => {
                commit('setUser', { user: response.data.content })
                resolve(response.data)
            }).catch(response => reject(response))
        });
    },
    fetchUsers({ commit, state }) {
        return new Promise((resolve, reject) => {
            api.get("/api/v1/users").then(response => {
                commit('setUsers', { users: response.data.content })
                resolve(response.data)
            }).catch(response => reject(response))
        });
    },
    addNewUser({ commit, state }, user) {
        return new Promise((resolve, reject) => {
            api.post("/api/v1/users", user)
                .then(response => {
                    if(response.status === 201 && response.data.success){
                        commit('setNewUser', { user: response.data.content });
                        resolve(response.data);
                    }else{
                        throw new Error("Something going wrong!");
                    }
                }).catch(error => {
                    reject(error)
                })
        })
    },
    editUser({ commit, state }, user) {
        return new Promise((resolve, reject) => {
            api.put("/api/v1/users/" + user.uuid, user)
                .then(response => {
                    if(response.data.success){
                        commit('setNewUser', { user: response.data.content });
                        resolve(response.data);
                    }else{
                        throw new Error("Something going wrong!");
                    }
                }).catch(error => {
                    reject(error)
                })
        })
    },
    resetUser({ commit, state }, user) {
        return new Promise((resolve, reject) => {
            api.put("/api/v1/users/" + user.uuid + "/reset", user)
                .then(response => {
                    if(response.data.success){
                        commit('setNewUser', { user: response.data.content });
                        resolve(response.data);
                    }else{
                        throw new Error("Something going wrong!");
                    }
                }).catch(error => {
                    reject(error)
                })
        })
    },
    banUser({commit, state}, uuid){
        return new Promise((resolve, reject) => {
            api.get(`/api/v1/users/${uuid}/status`)
                .then(response => {
                    if(response.data.success)
                        resolve(response.data);
                    else
                        throw new Error("Something going wrong!");
                }).catch((error) => {
                    reject(error);
                })
        });
    },
    deleteUser({commit, state}, uuid){
        return new Promise((resolve, reject) => {
            api.delete("/api/v1/users/" + uuid)
                .then(response => {
                    if(response.status === 204)
                        resolve(response);
                    else
                        throw new Error("Something going wrong!");
                }).catch((error) => {
                    reject(error);
                });
        });
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
                    if(response.status === 201){
                        commit('setBrand', { brand: response.data.content })
                        resolve(response.data)
                    }else{
                        throw new Error("Something going wrong!");
                    }
                })
                .catch(response => {
                    reject(response)
                })
        })
    },
    updateBrand({ commit, state }, data) {
        let uuid = data.get('uuid');
        if(uuid !== null){
            return new Promise((resolve, reject) => {
                api.post("/api/v1/brands/" + uuid, data, {
                    headers: {
                        "Content-Type": "multipart/form-data"
                    }
                })
                    .then(response => {
                        if(response.status === 200){
                            commit('setBrand', { brand: response.data.content })
                            resolve(response.data)
                        }else{
                            throw new Error("Something going wrong!");
                        }
                    })
                    .catch(response => {
                        reject(response)
                    })
            })
        }else{
            throw new Error("Something going wrong with the targeted entity!");
        }
    },
    deleteBrand({commit, state}, uuid){
        return new Promise((resolve, reject) => {
            api.delete("/api/v1/brands/" + uuid)
                .then(response => {
                    if(response.status === 204)
                        resolve(response);
                    else
                        throw new Error("Something going wrong!");
                }).catch((error) => {
                    reject(error);
                });
        });
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

            api.post("/api/v1/trackers" + (isStory ? "/story" : ""), data, {
                    headers: {
                        "Content-Type": "multipart/form-data"
                    }
                }).then(response => {
                    commit('setNewTracker', { tracker: response.data.content })
                    resolve(response.data)
                })
                .catch(error => {
                    reject(error)
                })
        })
    },
    changeTrackerStatus({commit, state}, uuid){
        return new Promise((resolve, reject) => {
            api.get(`/api/v1/trackers/${uuid}/status`)
                .then(response => {
                    if(response.data.success)
                        resolve(response.data);
                    else
                        throw new Error("Something going wrong!");
                }).catch((error) => {
                    reject(error);
                })
        });
    },
    deleteTracker({commit, state}, uuid){
        return new Promise((resolve, reject) => {
            api.delete("/api/v1/trackers/" + uuid)
                .then(response => {
                    if(response.status === 204)
                        resolve(response);
                    else
                        throw new Error("Something going wrong!");
                }).catch((error) => {
                    reject(error);
                });
        });
    },
    setActiveBrand({ commit, state }, brand) {
        return new Promise((resolve, reject) => {
            api.get(`/api/v1/users/active-brand/${brand.uuid}`)
                .then((response) => {
                    if(response.status === 200 && typeof response.data.content.selected_brand !== "undefined")
                        commit("setActiveBrand", {brand: response.data.content.selected_brand});
                    else
                        throw new Error("Something going wrong!");

                    resolve(response.data);
                })
                .catch((error) => {
                    reject(error);
                });
        });
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
    },
    fetchRoles({ commit, state }) {
        return new Promise((resolve, reject) => {
            api.get("/api/v1/roles").then(response => {
                commit('setRoles', { roles: response.data.content })
                resolve(response.data)
            }).catch(response => reject(response))
        });
    },
};

const mutations = {
    setDashboard: (state, { dashboard }) => {
        state.dashboard = dashboard;
    },
    setToken: (state, { token }) => {
        state.token = token;
    },
    setUser: (state, { user }) => {
        state.user = user;
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
        if (!brand && typeof state.brands.length !== "undefined" && state.brands.length > 0) {
            state.brands.forEach((item, index) => {
                if (item.id == state.user.selected_brand_id) {
                    brand = item
                }
            });
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
    },
    setRoles: (state, { roles }) => {
        state.roles = roles
    },
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
