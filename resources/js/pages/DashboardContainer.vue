<template>
<main id="main" class="dashboard">
    <MainNav :authenticatedUser="AuthenticatedUser" />
    <div id="content" ref="content" class="dashboard__content">
        <div class="dashboard__navigation">
            <TopNavItem :brands="brands" :activeBrand="activeBrand" :isSwitch="true" class="nav-switch"></TopNavItem>

            <TopNavItem :isSwitch="false">
                <template v-slot:button v-if="AuthenticatedUser">
                    <div class="avatar">
                        <!-- <img
                        src="https://medgoldresources.com/wp-content/uploads/2018/02/avatar-placeholder.gif"
                        alt
                     /> -->
                        <img v-bind:src="'https://ui-avatars.com/api/?color=039be5&name=' + AuthenticatedUser.name" />
                    </div>
                    <div class="text">
                        <p>{{ AuthenticatedUser.name }}</p>
                        <div class="icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" color="#000629" class="sc-fzqAbL fPXfOL">
                                <g fill="none" fill-rule="evenodd">
                                    <circle cx="12" cy="12" r="12" />
                                    <path fill="#000" d="M12.492 12.283L7.306 7 5 9.35 12.492 17 20 9.35 17.677 7z" />
                                </g>
                            </svg>
                        </div>
                    </div>
                </template>
                <template v-slot:dropdown>
                    <ul>
                        <li v-if="$can('edit-info', 'user') || (AuthenticatedUser && AuthenticatedUser.is_superadmin)">
                            <router-link :to="{ name: 'settings' }">
                                <div class="icon">
                                    <i class="fas fa-user-cog"></i>
                                </div>
                                <div class="text">Settings</div>
                            </router-link>
                        </li>
                        <li>
                            <a href="javascript:void(0);" @click="logout">
                                <div class="icon">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <div class="text">Logout</div>
                            </a>
                        </li>
                    </ul>
                </template>
            </TopNavItem>
        </div>
        <div class="dashboard__content__page">
            <Loader :visible="loading" />
            <router-view></router-view>
        </div>
    </div>
</main>
</template>

<script>
import MainNav from "../components/navigations/MainNav";
import TopNavItem from "../components/navigations/TopNavItem";
import {
    mapGetters,
    mapState
} from "vuex";
import Loader from '../components/partials/Loader';
import { api } from '../api/index';
import ability from '../services/ability';

export default {
    components: {
        MainNav,
        TopNavItem,
        Loader,
    },
    computed: {
        ...mapState("Loader", ["loading"]),
        ...mapGetters(["AuthenticatedUser", "brands"]),
        activeBrand(){
            if(this.AuthenticatedUser !== null && typeof this.AuthenticatedUser !== "undefined" && this.AuthenticatedUser.selected_brand){
                return this.AuthenticatedUser.selected_brand;
            }else{
                return null;
            }
        }
    },
    watch: {
        showDropdown: function (newValue, oldValue) {
            if (newValue && this.showDropdown) {
                document.body.addEventListener("click", this.hideDropdown);
            }
            if (!newValue) {
                document.body.removeEventListener("click", this.hideDropdown);
            }
        }
    },
    notifications: {
        showSuccessLogout: {
            type: "success",
            message: "Bye!",
        },
    },
    methods: {
        loadBrands(){
            // Fetch brands
            this.$store.dispatch("fetchBrands")
                .catch(error => {});
        },
        hideDropdown(e) {
            if (!e.target.closest(".dashboard__navigation--item")) {
                this.showDropdown = false;
            }
        },
        logout() {
            this.$store.dispatch("logout").finally(() => {
                this.showSuccessLogout();
                this.$router.push({
                    name: "login"
                }).catch(() => {});
            });
        },
    },
    beforeRouteEnter(to, from, next) {
        next((vm) => {
            let loggedIn = vm.$store.getters.isLogged;

            if(!loggedIn){
                next({ name: 'login' });
            }else{
                api.get("/api/abilities").then(response => {
                    if(typeof response.data.content !== 'undefined'){
                        ability.update(response.data.content);
                    }
                }).catch((error) => {});
            }
        });
    },
    mounted(){
        // Load brands
        if(typeof this.brands === "undefined" || this.brands === null || Object.values(this.brands).length === 0)
            this.loadBrands();
    },
    data() {
        return {
            showDropdown: false,
        };
    }
};
</script>
