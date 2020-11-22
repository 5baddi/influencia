<template>
   <div class="campaigns">
      <div class="hero">
         <div class="hero__intro">
            <h1>Dashboard</h1>
         </div>
      </div>
      <div class="p-1">
         <header class="cards" v-if="$can('analytics', 'campaign') || (AuthenticatedUser && AuthenticatedUser.is_superadmin)">
            <div class="card">
               <div class="number">{{ dashboard.brands && dashboard.brands.length ? dashboard.brands.length : '---' }}</div>
               <p class="description">NUMBER OF BRANDS</p>
            </div>
            <div class="card">
               <div class="number">10</div>
               <p class="description">NUMBER OF CAMPAIGNS</p>
            </div>
            <div class="card">
               <div class="number">10</div>
               <p class="description">NUMBER OF TRACKERS</p>
            </div>
            <div class="card">
               <div class="number">10</div>
               <p class="description">NUMBER OF INFLUENCERS</p>
            </div>
         </header>
      </div>
   </div>
</template>
<script>
import {mapGetters} from "vuex";

export default{
   computed: {
      ...mapGetters(["AuthenticatedUser", "dashboard"])
   },
   created() {
      // Fetch dashboard
      this.$store.dispatch("fetchDashboard")
         .catch(error => {});
   },
}
</script>