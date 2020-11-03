<template>
   <div class="campaigns">
      <div class="hero">
         <div class="hero__intro">
            <h1>{{ (campaign && campaign.name) ? campaign.name.toUpperCase() : 'Campagins' }}</h1>
            <ul class="breadcrumbs">
               <li>
                  <a href="#">Dashboard</a>
               </li>
               <li>
                  <a href="#">Campaigns</a>
               </li>
            </ul>
         </div>
         <div class="hero__actions" v-if="($can('create', 'campaign') || (AuthenticatedUser && AuthenticatedUser.is_superadmin)) && !campaign">
            <button
               :disabled="!activeBrand"
               class="btn btn-success"
               @click="showAddCampaignModal = !showAddCampaignModal"
            >Add new campagin</button>
         </div>
      </div>
      <div class="p-1" v-if="!campaign">
         <header class="cards" v-if="$can('analytics', 'campaign') || (AuthenticatedUser && AuthenticatedUser.is_superadmin)">
            <div class="card">
               <div class="number">{{ (campaigns && campaigns.all && campaigns.all.length > 0) ? campaigns.all.length : 0 }}</div>
               <p class="description">NUMBER OF CAMPAIGNS</p>
            </div>
            <div class="card">
               <div class="number">{{ (trackers && trackers.length > 0) ? trackers.length : 0 }}</div>
               <p class="description">NUMBER OF TRACKERS</p>
            </div>
            <div class="card">
               <div class="number">{{ campaigns && campaigns.impressions ? campaigns.impressions.toLocaleString().replace(/,/g, ' ') : '---' }}</div>
               <p class="description">TOTAL ESTIMATED IMPRESSIONS</p>
            </div>
            <div class="card">
               <div class="number">{{ campaigns && campaigns.communities ? campaigns.communities.toLocaleString().replace(/,/g, ' ') : '---' }}</div>
               <p class="description">TOTAL SIZE OF ACTIVATED COMMUNITIES</p>
            </div>
         </header>
         <div class="datatable-scroll" v-if="$can('list', 'campaign') || (AuthenticatedUser && AuthenticatedUser.is_superadmin)">
            <DataTable ref="campaignsDT" :columns="columns" fetchMethod="fetchCampaigns" responseField="all" cssClasses="table-card">
               <th slot="header">Actions</th>
               <td slot="body-row" slot-scope="row">
                  <router-link  v-if="$can('analytics', 'campaign') || (AuthenticatedUser && AuthenticatedUser.is_superadmin)" v-show="row.data.trackers_count > 0" :to="{name : 'campaigns', params: {uuid: row.data.original.uuid}}" class="icon-link" title="Statistics">
                     <i class="far fa-chart-bar"></i>
                  </router-link>
                  <!-- <button class="btn icon-link" @click="disableCampaign(row)" title="Stop tracking" v-if="$can('start-stop-tracking', 'campaign') || (AuthenticatedUser && AuthenticatedUser.is_superadmin)">
                     <i class="far fa-stop-circle"></i>
                  </button> -->
               </td>
            </DataTable>
         </div>
      </div>
      <CreateCampaignModal
         :show="showAddCampaignModal"
         @create="create"
         @dismiss="dismissAddCampaignModal"
      />
      <CampaignAnalytics v-if="campaign" :campaign="campaign"/>
   </div>
</template>
<script>
import CreateCampaignModal from "../components/modals/CreateCampaignModal";
import CampaignAnalytics from "../components/CampaignAnalytics";
import { mapGetters } from "vuex";
import moment from "moment";
import DataTableVue from '../components/DataTable.vue';
export default {
   components: {
      CreateCampaignModal,
      CampaignAnalytics
   },
   data() {
      return {
         showAddCampaignModal: false,
         isLoading: true,
         columns: [
            {
               name: "Campaign name",
               field: "name"
            },
            {
               name: "Campaign status",
               field: "status",
               callback: function(row){
                  return '<span class="status status-' + (row.status ? 'success' : 'danger') + '" title="' + (row.status ? 'Enabled' : 'Disabled') + '"></span>';
               }
            },
            {
               name: "Number of trackers",
               field: "all_trackers_count"
            },
            {
               name: "Created by",
               field: "user_id",
               callback: function(row){
                  return '<span class="badge badge-success">' + row.user.name + '</span>';
               }
            },
            {
               name: "Created at",
               field: "created_at",
               isDate: true,
               format: "DD/MM/YYYY"
            }
         ]
      };
   },
   beforeRouteEnter(to, from, next){
       next(vm => vm.initData());
   },
   beforeRouteUpdate(to, from, next){
       next(vm => vm.fetchCampaign())
   },
   created(){
      // this.initData();
   },
   watch: {
      $route: "initData"
   },
   methods: {
      initData(){
         this.$store.dispatch("fetchCampaigns");
         this.$store.dispatch("fetchTrackers");
         this.fetchCampaign();
      },
      fetchCampaign(){
         // Load user by UUID
         if(typeof this.$route.params.uuid !== 'undefined')
               this.$store.dispatch("fetchCampaignAnalytics", this.$route.params.uuid);
         else
               this.$store.commit("setCampaign", {campaign: null});
      },
      moment() {
         return moment();
      },
      dismissAddCampaignModal() {
         this.showAddCampaignModal = false;
      },
      showEditCampaignModal(){

      },
      create(payload) {
         payload = {
            ...payload,
            brand_id: this.$store.getters.activeBrand && this.$store.getters.activeBrand.id
         };
         this.$store.dispatch("addNewCampaign", payload).then(() => {
            // Reload DataTable
            this.$refs.campaignsDT.reloadData();

            this.createCampaignSuccess({ message: "Campaign created successfully" });
            this.dismissAddCampaignModal();
         });
      },
      // Delete campaign
      deleteCampaign(campaign){

      }
   },
   computed: {
      ...mapGetters(["AuthenticatedUser", "activeBrand", "campaigns", "campaign", "trackers"])
   },
   notifications: {
      createCampaignErrors: {
         type: "error"
      },
      createCampaignSuccess: {
         type: "success"
      }
   }
};
</script>
