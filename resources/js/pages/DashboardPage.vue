<template>
   <div class="campaigns">
      <div class="hero">
         <div class="hero__intro">
            <h1>Dashboard</h1>
         </div>
      </div>
      <div class="p-1">
         <header class="cards" v-if="$can('analytics', 'campaign') || (AuthenticatedUser && AuthenticatedUser.is_superadmin)">
            <div class="card purple-card">
                <div class="number text-white">{{ statistics.impressions | formatedNbr }}</div>
                <p class="description text-white">TOTAL ESTIMATED IMPRESSIONS</p>
            </div>
            <div class="card orange-card">
                <div class="number text-white">{{ statistics.communities | formatedNbr }}</div>
                <p class="description text-white">TOTAL SIZE OF ACTIVATED COMMUNITIES</p>
            </div>
            <div class="card green-card">
               <div class="number text-white">{{ statistics.campaigns_count | formatedNbr }}</div>
               <p class="description text-white">NUMBER OF CAMPAIGNS</p>
            </div>
            <div class="card cyan-card">
               <div class="number text-white">{{ statistics.trackers_count | formatedNbr }}</div>
               <p class="description text-white">NUMBER OF TRACKERS</p>
            </div>
         </header>
      </div>
      <div class="card-with-table">
         <h4>Latest added campaigns</h4>
         <DataTable ref="latestCampaigns" :columns="latestCampaignsColumns" :nativeData="statistics.latestCampaigns" :withPagination="false"/>
      </div>
      <div class="card-with-table">
         <h4>Latest added trackers</h4>
         <DataTable ref="latestTrackers" :columns="latestTrackersColumns" :nativeData="statistics.latestTrackers" :withPagination="false"/>
      </div>
   </div>
</template>
<script>
import {mapGetters} from "vuex";

export default {
   computed: {
      ...mapGetters(["AuthenticatedUser", "statistics"])
   },
   methods: {
      loadStatistics(){
         return this.$store.dispatch("fetchStatistics");
      }
   },
   mounted(){
      // Load statistics
      if(Object.keys(this.statistics).length === 0)
         this.loadStatistics();
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
   }
}
</script>