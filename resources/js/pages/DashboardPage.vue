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
               <div class="number">{{ dashboard.campaigns && dashboard.campaigns.length ? dashboard.campaigns.length : '---' }}</div>
               <p class="description">NUMBER OF CAMPAIGNS</p>
            </div>
            <div class="card">
               <div class="number">{{ dashboard.trackers && dashboard.trackers.length ? dashboard.trackers.length : '---' }}</div>
               <p class="description">NUMBER OF TRACKERS</p>
            </div>
            <div class="card">
               <div class="number">{{ dashboard.influencers && dashboard.influencers.length ? dashboard.influencers.length : '---' }}</div>
               <p class="description">NUMBER OF INFLUENCERS</p>
            </div>
         </header>
      </div>
      <!-- <div class="card-with-table">
         <h4>Latest added campaigns</h4>
         <DataTable :columns="latestCampaignsColumns" :nativeData="dashboard.latestCampaigns" :withPagination="false"/>
      </div>
      <div class="card-with-table">
         <h4>Latest added trackers</h4>
         <DataTable :columns="latestTrackersColumns" :nativeData="dashboard.latestTrackers" :withPagination="false"/>
      </div> -->
   </div>
</template>
<script>
import {mapGetters} from "vuex";

export default{
   computed: {
      ...mapGetters(["AuthenticatedUser", "dashboard"])
   },
   data(){
      return {
         latestCampaignsColumns: [
            {
               name: "Name",
               field: "name"
            },
            {
               name: "Activated Communities",
               field: "communities",
               isNbr: true
            },
            {
               name: "ESTIMATED IMPRESSIONS",
               field: "impressions",
               isNbr: true
            },
            {
               name: "ENGAGEMENTS",
               field: "engagements",
               isNbr: true
            },
            {
               name: "Videos views",
               field: "views",
               isNbr: true
            },
         ],
         latestTrackersColumns: [
            {
               name: "Name",
               field: "name"
            },
            {
               name: "Activated Communities",
               field: "communities",
               isNbr: true
            },
            {
               name: "ESTIMATED IMPRESSIONS",
               field: "impressions",
               isNbr: true
            },
            {
               name: "ENGAGEMENTS",
               field: "engagements",
               isNbr: true
            },
            {
               name: "Videos views",
               field: "views",
               isNbr: true
            },
         ]
      }
   },
   created() {
      // Fetch dashboard
      this.$store.dispatch("fetchDashboard")
         .catch(error => {});
   },
}
</script>