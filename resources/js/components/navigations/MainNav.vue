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
      <div class="dashboard__sidebar__profile">
         <h2>{{ AuthenticatedUser.name }}</h2>
         <p>{{ AuthenticatedUser.email }}</p>
         <div class="avatar">
            <img
               src="https://medgoldresources.com/wp-content/uploads/2018/02/avatar-placeholder.gif"
               alt="avatar"
            />
         </div>
      </div>
      <nav class="dashboard__sidebar__navigation">
         <ul>
            <li :class="{active : currentRouteName == `search`}">
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
            </li>
            <li :class="{active : currentRouteName == `campagins`}">
               <router-link :to="{name : 'campagins'}">
                  <span class="icon">
                     <svg width="24" height="24" viewBox="0 0 24 24" class="sc-fznyYp kgPnwn">
                        <g fill="none" fill-rule="evenodd">
                           <circle cx="12" cy="12" r="12" />
                           <path
                              fill="#fff"
                              fill-rule="nonzero"
                              d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm7.93 9H13V4.07c3.61.45 6.48 3.32 6.93 6.93zM4 12c0-4.07 3.06-7.44 7-7.93v15.86c-3.94-.49-7-3.86-7-7.93zm9 7.93V13h6.93A8.002 8.002 0 0113 19.93z"
                           />
                        </g>
                     </svg>
                  </span>
                  <span class="text">Campaigns</span>
               </router-link>
            </li>
            <li :class="{active : currentRouteName == `trackers`}">
               <router-link :to="{name: 'trackers'}">
                  <span class="icon">
                     <svg width="24" height="24" viewBox="0 0 24 24" class="sc-fzpisO jZmyVc">
                        <g fill="none" fill-rule="evenodd">
                           <circle cx="12" cy="12" r="12" />
                           <path
                              fill="#fff"
                              d="M2 2h2v20H2V2zm20 18v2H4v-2h18zM7 8h2v10H7V8zm5-4h2v14h-2V4zm5 8h2v6h-2v-6z"
                           />
                        </g>
                     </svg>
                  </span>
                  <span class="text">Trackers</span>
               </router-link>
            </li>
            <li :class="{active : currentRouteName == `brands`}">
               <router-link :to="{name: 'brands'}">
                  <div class="icon">
                     <svg width="18" height="18" viewBox="0 0 18 18">
                        <g fill="none" fill-rule="evenodd">
                           <circle cx="9" cy="9" r="9" />
                           <path
                              fill="#fff"
                              d="M12.495 3.39l2.123 2.123-2.123 2.122-2.122-2.122 2.122-2.123zm-5.745.36v3h-3v-3h3zm7.5 7.5v3h-3v-3h3zm-7.5 0v3h-3v-3h3zm5.745-9.982L8.25 5.505l4.245 4.245 4.245-4.245-4.245-4.237zM8.25 2.25h-6v6h6v-6zm7.5 7.5h-6v6h6v-6zm-7.5 0h-6v6h6v-6z"
                           />
                        </g>
                     </svg>
                  </div>
                  <div class="text">Brands</div>
               </router-link>
            </li>
            <li :class="{active : currentRouteName == `users`}">
               <router-link :to="{name: 'users'}">
                  <div class="icon">
                     <svg width="24" height="24" viewBox="0 0 24 24" class="sc-fzoJMP cyFmdx">
                        <g fill="none" fill-rule="evenodd">
                           <circle cx="12" cy="12" r="12" />
                           <path
                              fill="#fff"
                              d="M19.43 12.98c.04-.32.07-.64.07-.98 0-.34-.03-.66-.07-.98l2.11-1.65c.19-.15.24-.42.12-.64l-2-3.46a.5.5 0 00-.61-.22l-2.49 1c-.52-.4-1.08-.73-1.69-.98l-.38-2.65A.488.488 0 0014 2h-4c-.25 0-.46.18-.49.42l-.38 2.65c-.61.25-1.17.59-1.69.98l-2.49-1a.566.566 0 00-.18-.03c-.17 0-.34.09-.43.25l-2 3.46c-.13.22-.07.49.12.64l2.11 1.65c-.04.32-.07.65-.07.98 0 .33.03.66.07.98l-2.11 1.65c-.19.15-.24.42-.12.64l2 3.46a.5.5 0 00.61.22l2.49-1c.52.4 1.08.73 1.69.98l.38 2.65c.03.24.24.42.49.42h4c.25 0 .46-.18.49-.42l.38-2.65c.61-.25 1.17-.59 1.69-.98l2.49 1c.06.02.12.03.18.03.17 0 .34-.09.43-.25l2-3.46c.12-.22.07-.49-.12-.64l-2.11-1.65zm-1.98-1.71c.04.31.05.52.05.73 0 .21-.02.43-.05.73l-.14 1.13.89.7 1.08.84-.7 1.21-1.27-.51-1.04-.42-.9.68c-.43.32-.84.56-1.25.73l-1.06.43-.16 1.13-.2 1.35h-1.4l-.19-1.35-.16-1.13-1.06-.43c-.43-.18-.83-.41-1.23-.71l-.91-.7-1.06.43-1.27.51-.7-1.21 1.08-.84.89-.7-.14-1.13c-.03-.31-.05-.54-.05-.74 0-.2.02-.43.05-.73l.14-1.13-.89-.7-1.08-.84.7-1.21 1.27.51 1.04.42.9-.68c.43-.32.84-.56 1.25-.73l1.06-.43.16-1.13.2-1.35h1.39l.19 1.35.16 1.13 1.06.43c.43.18.83.41 1.23.71l.91.7 1.06-.43 1.27-.51.7 1.21-1.07.85-.89.7.14 1.13zM12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 6c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"
                           />
                        </g>
                     </svg>
                  </div>
                  <div class="text">Users</div>
               </router-link>
            </li>
            <li :class="{active : currentRouteName == `settings`}">
               <router-link :to="{name: 'settings'}">
                  <div class="icon">
                     <svg width="24" height="24" viewBox="0 0 24 24" class="sc-fzoJMP cyFmdx">
                        <g fill="none" fill-rule="evenodd">
                           <circle cx="12" cy="12" r="12" />
                           <path
                              fill="#fff"
                              d="M19.43 12.98c.04-.32.07-.64.07-.98 0-.34-.03-.66-.07-.98l2.11-1.65c.19-.15.24-.42.12-.64l-2-3.46a.5.5 0 00-.61-.22l-2.49 1c-.52-.4-1.08-.73-1.69-.98l-.38-2.65A.488.488 0 0014 2h-4c-.25 0-.46.18-.49.42l-.38 2.65c-.61.25-1.17.59-1.69.98l-2.49-1a.566.566 0 00-.18-.03c-.17 0-.34.09-.43.25l-2 3.46c-.13.22-.07.49.12.64l2.11 1.65c-.04.32-.07.65-.07.98 0 .33.03.66.07.98l-2.11 1.65c-.19.15-.24.42-.12.64l2 3.46a.5.5 0 00.61.22l2.49-1c.52.4 1.08.73 1.69.98l.38 2.65c.03.24.24.42.49.42h4c.25 0 .46-.18.49-.42l.38-2.65c.61-.25 1.17-.59 1.69-.98l2.49 1c.06.02.12.03.18.03.17 0 .34-.09.43-.25l2-3.46c.12-.22.07-.49-.12-.64l-2.11-1.65zm-1.98-1.71c.04.31.05.52.05.73 0 .21-.02.43-.05.73l-.14 1.13.89.7 1.08.84-.7 1.21-1.27-.51-1.04-.42-.9.68c-.43.32-.84.56-1.25.73l-1.06.43-.16 1.13-.2 1.35h-1.4l-.19-1.35-.16-1.13-1.06-.43c-.43-.18-.83-.41-1.23-.71l-.91-.7-1.06.43-1.27.51-.7-1.21 1.08-.84.89-.7-.14-1.13c-.03-.31-.05-.54-.05-.74 0-.2.02-.43.05-.73l.14-1.13-.89-.7-1.08-.84.7-1.21 1.27.51 1.04.42.9-.68c.43-.32.84-.56 1.25-.73l1.06-.43.16-1.13.2-1.35h1.39l.19 1.35.16 1.13 1.06.43c.43.18.83.41 1.23.71l.91.7 1.06-.43 1.27-.51.7 1.21-1.07.85-.89.7.14 1.13zM12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 6c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"
                           />
                        </g>
                     </svg>
                  </div>
                  <div class="text">Settings</div>
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