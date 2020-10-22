<template>
   <aside class="dashboard__sidebar" id="main-sidebar">
      <header>
         <div class="dashboard__sidebar--content">
            <div class="logo">
               <img
                  src="http://angular-material.fusetheme.com/assets/images/logos/fuse.svg"
                  alt="logo"
               />
            </div>
            <h1>INFLUENCIA</h1>
         </div>
         <button class="dashboard__sidebar--toggle btn" @click="toggle">
            <span></span>
            <span></span>
            <span></span>
         </button>
      </header>
      <div class="dashboard__sidebar__profile" v-if="AuthenticatedUser">
         <h2>{{ AuthenticatedUser.name }}</h2>
         <p>{{ AuthenticatedUser.email }}</p>
         <div class="avatar">
            <!-- <img
               src="https://medgoldresources.com/wp-content/uploads/2018/02/avatar-placeholder.gif"
               alt="avatar"
            /> -->
            <img v-bind:src="'https://ui-avatars.com/api/?color=039be5&name=' + AuthenticatedUser.name" alt="avatar"/>
         </div>
      </div>
      <nav class="dashboard__sidebar__navigation">
         <ul>
            <!-- <li v-if="$can('search', 'scraper') || AuthenticatedUser.is_superadmin" :class="{active : currentRouteName == `search`}">
               <router-link :to="{name : 'search'}">
                  <span class="icon">
                     <svg width="24" height="24" viewBox="0 0 24 24" class="sc-fzoant dBHRFd">
                        <g fill="none" fill-rule="evenodd">
                           <circle cx="12" cy="12" r="12" />
                           <path
                              fill="#fff"
                              fill-rule="nonzero"
                              d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0016 9.5 6.5 6.5 0 109.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"
                           />
                        </g>
                     </svg>
                  </span>
                  <span class="text">Search</span>
               </router-link>
            </li> -->
            <li v-if="$can('list', 'campaign') || AuthenticatedUser.is_superadmin" :class="{active : currentRouteName == `campagins`}">
               <router-link :to="{name : 'campaigns'}">
                  <span class="icon">
                     <i class="fas fa-chart-pie"></i>
                  </span>
                  <span class="text">Campaigns</span>
               </router-link>
            </li>
            <li v-if="$can('list', 'tracker') || AuthenticatedUser.is_superadmin" :class="{active : currentRouteName == `trackers`}">
               <router-link :to="{name: 'trackers'}">
                  <span class="icon">
                     <i class="fas fa-code-branch"></i>
                  </span>
                  <span class="text">Trackers</span>
               </router-link>
            </li>
            <!-- <can I="list" a="brand"> -->
            <li v-if="$can('list', 'brand') || AuthenticatedUser.is_superadmin" :class="{active : currentRouteName == `brands`}">
               <router-link :to="{name: 'brands'}">
                  <div class="icon">
                     <i class="fas fa-copyright"></i>
                  </div>
                  <div class="text">Brands</div>
               </router-link>
            </li>
            <!-- </can> -->
            <li v-if="$can('list', 'influencer') || AuthenticatedUser.is_superadmin" :class="{active : currentRouteName == `influencers`}">
               <router-link :to="{name: 'influencers'}">
                  <div class="icon">
                     <i class="fas fa-podcast"></i>
                  </div>
                  <div class="text">Influencers</div>
               </router-link>
            </li>
            <li v-if="$can('list', 'user') || AuthenticatedUser.is_superadmin" :class="{active : currentRouteName == `users`}">
               <router-link :to="{name: 'users'}">
                  <div class="icon">
                     <i class="fas fa-users"></i>
                  </div>
                  <div class="text">Users</div>
               </router-link>
            </li>
            <li v-if="$can('assign-role', 'user') || AuthenticatedUser.is_superadmin" :class="{active : currentRouteName == `roles`}">
               <router-link :to="{name: 'roles'}">
                  <div class="icon">
                     <i class="fas fa-key"></i>
                  </div>
                  <div class="text">Roles</div>
               </router-link>
            </li>
         </ul>
      </nav>
   </aside>
</template>
<script>
import { mapGetters } from "vuex";
export default {
   data() {
      return {
         isNavOpen: true
      };
   },
   computed: {
      currentRouteName() {
         return this.$route.name;
      },
      ...mapGetters(["AuthenticatedUser"])
   },
   methods: {
      toggle() {
         this.isNavOpen = !this.isNavOpen;
      },
      addClass() {
         document.body.classList.add("nav-collapsed");
      },
      removeClass() {
         document.body.classList.remove("nav-collapsed");
      }
   },
   watch: {
      isNavOpen: {
         handler(newValue, oldValue) {
            if (newValue === false) {
               document.body.classList.add("nav-collapsed");
               document.getElementById("main-sidebar").addEventListener("mouseenter", this.removeClass);
               document.getElementById("main-sidebar").addEventListener("mouseleave", this.addClass);
            } else if (newValue === true) {
               document.getElementById("main-sidebar").removeEventListener("mouseenter", this.removeClass);
               document.getElementById("main-sidebar").removeEventListener("mouseleave", this.addClass);
               document.body.classList.remove("nav-collapsed");
            }
         }
      }
   }
};
</script>