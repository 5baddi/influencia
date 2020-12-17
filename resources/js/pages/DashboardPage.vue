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
                <div class="number text-white">{{ statistics.impressions || formatedNbr }}</div>
                <p class="description text-white">TOTAL ESTIMATED IMPRESSIONS</p>
            </div>
            <div class="card orange-card">
                <div class="number text-white">{{ statistics.communities || formatedNbr }}</div>
                <p class="description text-white">TOTAL SIZE OF ACTIVATED COMMUNITIES</p>
            </div>
            <div class="card green-card">
               <div class="number text-white">{{ statistics.campaigns_count || formatedNbr }}</div>
               <p class="description text-white">NUMBER OF CAMPAIGNS</p>
            </div>
            <div class="card cyan-card">
               <div class="number text-white">{{ statistics.trackers_count || formatedNbr }}</div>
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
   filters: {
      formatedNbr: function(value){
         try{
               if(typeof value === "undefined" || value === 0 || value === null)
               return '---';

               return new Intl.NumberFormat('en-US').format(value.toFixed(2)).replace(/,/g, ' ');
         }catch(error){
               return '---';
         }
      }
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
      // Fetch data
      this.$store.dispatch("fetchStatistics").catch(error => {});
   },
}
</script>