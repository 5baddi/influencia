<template>
   <main id="main" class="dashboard">
      <MainNav />
      <div id="content" class="dashboard__content">
         <div class="dashboard__navigation">
            <TopNavItem :is_switch="true" class="nav-switch" v-if="!isLoading"></TopNavItem>

            <TopNavItem :is_switch="false">
               <template v-slot:button>
                  <div class="avatar">
                     <img
                        src="https://medgoldresources.com/wp-content/uploads/2018/02/avatar-placeholder.gif"
                        alt
                     />
                  </div>
                  <div class="text">
                     <p>{{ AuthenticatedUser.name }}</p>
                     <div class="icon">
                        <svg
                           width="24"
                           height="24"
                           viewBox="0 0 24 24"
                           color="#000629"
                           class="sc-fzqAbL fPXfOL"
                        >
                           <g fill="none" fill-rule="evenodd">
                              <circle cx="12" cy="12" r="12" />
                              <path
                                 fill="#000"
                                 d="M12.492 12.283L7.306 7 5 9.35 12.492 17 20 9.35 17.677 7z"
                              />
                           </g>
                        </svg>
                     </div>
                  </div>
               </template>
               <template v-slot:dropdown>
                  <ul>
                     <li>
                        <a href="#" @click="logout">
                           <div class="icon">
                              <svg width="24" height="24" viewBox="0 0 24 24">
                                 <g fill="none" fill-rule="evenodd">
                                    <circle cx="12" cy="12" r="12" />
                                    <path
                                       fill="#333333de"
                                       d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM9 6c0-1.66 1.34-3 3-3s3 1.34 3 3v2H9V6zm9 14H6V10h12v10zm-6-3c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z"
                                    />
                                 </g>
                              </svg>
                           </div>
                           <div class="text">Logout</div>
                        </a>
                     </li>
                  </ul>
               </template>
            </TopNavItem>
         </div>
         <div class="dashboard__content__page">
            <router-view></router-view>
         </div>
      </div>
   </main>
</template>
<script>
import MainNav from "../components/navigations/MainNav";
import TopNavItem from "../components/navigations/TopNavItem";
import { mapGetters } from "vuex";
export default {
   components: {
      MainNav,
      TopNavItem
   },
   data() {
      return {
         isLoading: true,
         showDropdown: false
      };
   },
   created() {
      if (!this.$store.getters.brands) {
         this.$store.dispatch("fetchBrands").then(() => (this.isLoading = false));
         return;
      }
      this.isLoading = false;
   },
   methods: {
      hideDropdown(e) {
         if (!e.target.closest(".dashboard__navigation--item")) {
            this.showDropdown = false;
         }
      },
      logout() {
         this.$store.dispatch("logout").finally(() => {
            this.showSuccessLogout();
            this.$router.push({ name: "login" });
         });
      }
   },
   watch: {
      showDropdown: function(newValue, oldValue) {
         if (newValue && this.showDropdown) {
            document.body.addEventListener("click", this.hideDropdown);
         }
         if (!newValue) {
            document.body.removeEventListener("click", this.hideDropdown);
         }
      }
   },
   computed: {
      ...mapGetters(["AuthenticatedUser", "brands"])
   },
   notifications: {
      showSuccessLogout: {
         type: "success",
         message: "Bye!"
      }
   },
   beforeRouteEnter(to, from, next) {
      next(vm => {
         const loggedIn = !!vm.$store.getters.isLogged && !!localStorage.getItem("user");
         if (!loggedIn) {
            next("/login");
            return;
         }
         next();
      });
   }
};
</script>