<template>
<aside class="dashboard__sidebar" id="main-sidebar">
    <header>
        <div class="dashboard__sidebar--content">
            <div class="logo">
                <router-link :to="{name : 'dashboard'}">
                    <img v-show="isNavOpen" src="@assets/img/log-inf.png" alt="logo" />
                    <img v-show="!isNavOpen" src="@assets/img/log-inf-mini.png" alt="logo" />
                </router-link>
            </div>
        </div>
        <button class="dashboard__sidebar--toggle btn" @click="toggle">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </header>
    <nav class="dashboard__sidebar__navigation">
        <ul>
            <li :class="{active : currentRouteName == 'dashboard'}">
                <router-link :to="{name : 'dashboard'}">
                    <span class="icon">
                        <i class="fas fa-columns"></i>
                    </span>
                    <span class="text">Dashboard</span>
                </router-link>
            </li>
            <li v-if="$can('search', 'scraper') || (authenticatedUser && authenticatedUser.is_superadmin)" :class="{active : currentRouteName == `search`}">
                <router-link :to="{name : 'search'}">
                    <span class="icon">
                        <i class="fas fa-search"></i>
                    </span>
                    <span class="text">Search</span>
                </router-link>
            </li>
            <li v-if="$can('list', 'campaign') || (authenticatedUser && authenticatedUser.is_superadmin)" :class="{active : currentRouteName == `campaigns`}">
                <router-link :to="{name : 'campaigns'}">
                    <span class="icon">
                        <i class="fas fa-chart-pie"></i>
                    </span>
                    <span class="text">Campaigns</span>
                </router-link>
            </li>
            <li v-if="$can('list', 'tracker') || (authenticatedUser && authenticatedUser.is_superadmin)" :class="{active : currentRouteName == `trackers`}">
                <router-link :to="{name: 'trackers'}">
                    <span class="icon">
                        <i class="fas fa-code-branch"></i>
                    </span>
                    <span class="text">Trackers</span>
                </router-link>
            </li>
            <li v-if="$can('list', 'tracker') || (authenticatedUser && authenticatedUser.is_superadmin)" :class="{active : ['stories', 'new_story'].includes(currentRouteName) }">
                <router-link :to="{name: 'stories'}">
                    <span class="icon">
                        <i class="far fa-clock"></i>
                    </span>
                    <span class="text">Stories</span>
                </router-link>
            </li>
            <li v-if="$can('list', 'influencer') || (authenticatedUser && authenticatedUser.is_superadmin)" :class="{active : currentRouteName == `influencers`}">
                <router-link :to="{name: 'influencers'}">
                    <div class="icon">
                        <i class="fas fa-podcast"></i>
                    </div>
                    <div class="text">Influencers</div>
                </router-link>
            </li>
            <!-- <can I="list" a="brand"> -->
            <li v-if="$can('list', 'brand') || (authenticatedUser && authenticatedUser.is_superadmin)" :class="{active : currentRouteName == `brands`}">
                <router-link :to="{name: 'brands'}">
                    <div class="icon">
                        <i class="fas fa-copyright"></i>
                    </div>
                    <div class="text">Brands</div>
                </router-link>
            </li>
            <!-- </can> -->
            <li v-if="$can('list', 'user') || (authenticatedUser && authenticatedUser.is_superadmin)" :class="{active : currentRouteName == `users`}">
                <router-link :to="{name: 'users'}">
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="text">Users</div>
                </router-link>
            </li>
            <!-- <li v-if="$can('assign-role', 'user') || (authenticatedUser && authenticatedUser.is_superadmin)" :class="{active : currentRouteName == `roles`}">
               <router-link :to="{name: 'roles'}">
                  <div class="icon">
                     <i class="fas fa-key"></i>
                  </div>
                  <div class="text">Roles</div>
               </router-link>
            </li> -->
        </ul>
    </nav>
</aside>
</template>

<script>
export default {
    data() {
        return {
            navCurrentState: true
        };
    },
    props:{
        authenticatedUser: {
            type: [Object, undefined]
        }
    },
    computed: {
        currentRouteName() {
            return this.$route.name;
        },
        isNavOpen(){
            return this.navCurrentState;
        }
    },
    methods: {
        toggle() {
            this.navCurrentState = !this.navCurrentState;

            if(this.navCurrentState === false){
                document.body.classList.add("nav-collapsed");
                document.getElementById("main-sidebar").addEventListener("mouseenter", this.removeClass);
                document.getElementById("main-sidebar").addEventListener("mouseleave", this.addClass);   
            }else{
                document.getElementById("main-sidebar").removeEventListener("mouseenter", this.removeClass);
                document.getElementById("main-sidebar").removeEventListener("mouseleave", this.addClass);
                document.body.classList.remove("nav-collapsed");
            }
        },
        addClass() {
            document.body.classList.add("nav-collapsed");
        },
        removeClass() {
            document.body.classList.remove("nav-collapsed");
        }
    },
};
</script>
