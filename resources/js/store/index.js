
import Vue from 'vue';
import Vuex from 'vuex';
import { api } from '../api';
import { Loader } from './loader';
import ability from '../services/ability';
// import createPersistedState from "vuex-persistedstate";
import SecureLS from "secure-ls";

Vue.use(Vuex);

// Init
let ls = new SecureLS();

function fatchLocalUser() {
    try{
        if (ls.get("user") && ls.get("user") !== 'undefined') {
            const user = JSON.parse(ls.get("user"));
            api.defaults.headers.common.Authorization = `Bearer ${user.token}`;

            return user;
        }
    }catch(error){
        return null;
    }

    return null;
}

const state = () => ({
    user: fatchLocalUser(),
    token: null,
    brands: [],
    users: [],
    campaigns: [],
    campaign: null,
    statistics: {},
    trackers: [],
    tracker: null,
    influencers: [],
    influencer: null,
    roles: [],
});

const getters = {
    AuthenticatedUser: state => state.user,
    Token: state => state.token,
    isLogged: state => typeof state.user !== "undefined" && state.user !== null,
    isAdmin: state => state.user.is_superadmin,
    brands: state => state.brands,
    users: state => state.users,
    campaigns: state => state.campaigns,
    campaign: state => state.campaign,
    statistics: state => state.statistics,
    trackers: state => state.trackers,
    tracker: state => state.tracker,
    influencers: state => state.influencers,
    influencer: state => state.influencer,
    roles: state => state.roles,
};

const actions = {
    login({ commit, dispatch }, credentials) {

        return new Promise((resolve, reject) => {
            api.post('/oauth', credentials).then((response) => {
                if(response.status === 200 && response.data.success && response.data.content){
                    // Store user to local storage
                    let user = response.data.content.user;
                    user.token = response.data.content.token;
                    ls.set("user", JSON.stringify(user));

                    // Save user & token state
                    commit("setUser", { user: user});
                    commit("setToken", { token: user.token });
                    commit("setToken", { token: user.token });

                    // Send token to authorization header
                    api.defaults.headers.common.Authorization = `Bearer ${user.token}`;

                    // Set brands
                    if(!user.is_superadmin){
                        commit("setBrands", user.brands);
                    }else{
                        dispatch("fetchBrands");
                    }

                    // Load statistics
                    dispatch("fetchStatistics");

                    resolve(response.data);
                }else{
                    reject(new Error("Something going wrong!"));
                }
            }).catch(error => reject(error));
        })
    },
    logout({ commit, state }) {
        return new Promise((resolve, reject) => {

            ls.remove("user");

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
    fetchInfluencerContent({ commit, state }, attr) {
        return new Promise((resolve, reject) => {
            api.get("/api/v1/influencers/" + attr.uuid + "/content?page=" + (attr.page ? attr.page : 1)).then(response => {
                if(response.status === 200 && response.data.success)
                    resolve(response.data)
                else
                    throw new Error("Something going wrong!");
            }).catch(response => reject(response))
        });
    },
    addInfluencer({ commit, state }, data) {
        return new Promise((resolve, reject) => {
            api.post("/api/v1/influencers", data)
                .then(response => {
                    if(response.status === 200 && response.data.success){
                        resolve(response.data)
                    }else{
                        throw new Error("Something going wrong!");
                    }
                })
                .catch(response => {
                    reject(response)
                });
        })
    },
    deleteInfluencer({commit, state}, uuid){
        return new Promise((resolve, reject) => {
            api.delete("/api/v1/influencers/" + uuid)
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
                    if(response.status === 201 && response.data.success){
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
                        if(response.status === 200 && response.data.success){
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
    deleteCampagin({commit, state}, uuid){
        return new Promise((resolve, reject) => {
            api.delete("/api/v1/campaigns/" + uuid)
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
    updateCampaign({ commit, state }, data) {
        if(data.uuid !== null && typeof data.uuid !== "undefined"){
            return new Promise((resolve, reject) => {
                api.put("/api/v1/campaigns/" + data.uuid, data)
                    .then(response => {
                        if(response.status === 200){
                            commit('setCampaigns', { campaigns: response.data.content })
                            resolve(response.data)
                        }else{
                            throw new Error("Something going wrong!");
                        }
                    })
                    .catch(response => {
                        reject(response)
                    })
            });
        }else{
            throw new Error("campaign not found!");
        }
    },
    deleteCampaign({commit, state}, uuid){
        return new Promise((resolve, reject) => {
            api.delete("/api/v1/campaigns/" + uuid)
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
    setActiveBrand({ commit, state, dispatch }, brand) {
        if(brand !== null && typeof brand.uuid !== "undefined"){
            return new Promise((resolve, reject) => {
                api.get(`/api/v1/users/active-brand/${brand.uuid}`)
                    .then((response) => {
                        if(response.status === 200 && typeof response.data.content.selected_brand !== "undefined" && (typeof state.user.selected_brand.uuid.id === "undefined" || response.data.content.selected_brand.id !== state.user.selected_brand.uuid.id)){
                            let user = response.data.content;
                            user.token = state.token;
                            ls.set("user", JSON.stringify(user));

                            commit('setUser', { user: user });

                            // Reload all data
                            dispatch("fetchStatistics");
                            dispatch("fetchCampaigns");
                            dispatch("fetchTrackers");
                            dispatch("fetchInfluencers");
                        }else{
                            throw new Error("Something going wrong!");
                        }

                        resolve(response.data);
                    })
                    .catch((error) => {
                        // commit("setActiveBrand", {brand: null});

                        reject(error);
                    });
            });
        }else{
            throw new Error("Something going wrong!");
        }
    },
    fetchCampaigns({ commit, state }) {
        return new Promise((resolve, reject) => {
            if (state.user.selected_brand.uuid) {
                api.get(`/api/v1/${state.user.selected_brand.uuid}/campaigns`)
                    .then((response) => {
                        commit('setCampaigns', { campaigns: response.data.content })
                        resolve(response.data);
                    })
                    .catch((error) => {
                        reject(error)
                    });
            }else{
                reject(new Error("Something going wrong!"));
            }

        });
    },
    fetchCampaignsBy({ commit, state }, query) {
        return new Promise((resolve, reject) => {
            if (state.user.selected_brand.uuid) {
                api.get(`/api/v1/${state.user.selected_brand.uuid}/campaigns/search/${query}`)
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
    fetchStatistics({ commit, state }) {
        return new Promise((resolve, reject) => {
            api.get(`/api/v1/${state.user.selected_brand.uuid}/campaigns/statistics`).then(response => {
                commit('setStatistics', { statistics: response.data.content })
                resolve(response.data)
            }).catch(response => reject(response))
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
            if (state.user.selected_brand.uuid) {
                api.get(`/api/v1/${state.user.selected_brand.uuid}/trackers`)
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
    fetchTrackersBy({ commit, state }, query) {
        return new Promise((resolve, reject) => {
            if (state.user.selected_brand.uuid) {
                api.get(`/api/v1/${state.user.selected_brand.uuid}/trackers/search/${query}`)
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
    fetchTrackersByCampaign({ commit, state }, campaign) {
        return new Promise((resolve, reject) => {
            if (state.user.selected_brand.uuid) {
                api.get(`/api/v1/${state.user.selected_brand.uuid}/trackers/${campaign}`)
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
    fetchTrackerAnalytics({ commit, state }, uuid) {
        return new Promise((resolve, reject) => {
            api.get("/api/v1/trackers/" + uuid + "/analytics").then(response => {
                if(response.status === 200 && response.data.success){
                    commit('setTracker', { tracker: response.data.content })
                    resolve(response.data)
                }else{
                    throw new Error("Something going wrong!");
                }
            }).catch(error => reject(error))
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
    setNewCampaign: (state, { campaign }) => {
        if (!state.campaigns) {
            state.campaigns = [];
        }

        state.campaigns.push(campaign);
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
    setStatistics: (state, { statistics }) => {
        state.statistics = statistics;
    },
    setTrackers: (state, { trackers }) => {
        state.trackers = trackers;
    },
    setTracker: (state, { tracker }) => {
        state.tracker = tracker;
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

// Save data state
// const dataState = createPersistedState({
//     paths: [
//         'brands',
//         'activeBrand',
//         'users',
//         'campaigns',
//         'statistics',
//         'trackers',
//         'influencers',
//         'roles'
//     ],
//     storage: {
//         getItem: (key) => ls.get(key),
//         setItem: (key, value) => ls.set(key, value),
//         removeItem: (key) => ls.remove(key),
//     },
// });

export default new Vuex.Store({
    state: state,
    getters: getters,
    actions: actions,
    mutations: mutations,
    modules: {
        Loader
    },
    plugins: [
        updateAbilities,
        // dataState
    ]
});
