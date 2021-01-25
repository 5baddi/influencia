<template>
   <div class="campaigns">
      <header class="hero">
         <div class="hero__intro">
            <h1>Dashboard</h1>
         </div>
      </header>
      <div class="p-1">
         <div class="cards" v-if="$can('analytics', 'campaign') || (AuthenticatedUser && AuthenticatedUser.is_superadmin)">
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
         </div>
         <div class="datatable-scroll">
            <h4>Latest added campaigns</h4>
            <DataTable cssClasses="table-card" ref="latestCampaigns" :columns="latestCampaignsColumns" :nativeData="statistics.campaigns" :withPagination="false"/>
         </div>
         <div class="datatable-scroll">
            <h4>Latest added trackers</h4>
            <DataTable cssClasses="table-card" ref="latestTrackers" :columns="latestTrackersColumns" :nativeData="statistics.trackers" :withPagination="false"/>
         </div>
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
      if(typeof this.statistics === "undefined" || this.statistics === null || Object.values(this.statistics).length === 0)
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
               isNativeNbr: true
            },
            {
               name: "ESTIMATED IMPRESSIONS",
               field: "impressions",
               isNativeNbr: true
            },
            {
               name: "ENGAGEMENTS",
               field: "engagements",
               isNativeNbr: true
            },
            {
               name: "Videos views",
               field: "video_views",
               isNativeNbr: true
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
               isNativeNbr: true
            },
            {
               name: "ESTIMATED IMPRESSIONS",
               field: "impressions",
               isNativeNbr: true
            },
            {
               name: "ENGAGEMENTS",
               field: "engagements",
               isNativeNbr: true
            },
            {
               name: "Videos views",
               field: "video_views",
               isNativeNbr: true
            },
         ]
      }
   }
}
</script>