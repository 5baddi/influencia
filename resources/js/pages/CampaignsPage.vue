<template>
   <div class="campaigns">
      <div class="hero">
         <div class="hero__intro">
            <h1>{{ (campaign && campaign.data.name) ? campaign.data.name.toUpperCase() : 'Campagins' }}</h1>
            <ul class="breadcrumbs">
               <li>
                  <a href="#">Dashboard</a>
               </li>
               <li>
                  <a href="#">Campaigns</a>
               </li>
            </ul>
         </div>
         <div class="hero__actions" v-if="($can('create', 'campaign') || AuthenticatedUser.is_superadmin) && !campaign">
            <button
               :disabled="!activeBrand"
               class="btn btn-success"
               @click="showAddCampaignModal = !showAddCampaignModal"
            >Add new campagin</button>
         </div>
      </div>
      <div class="p-1" v-if="!campaign">
         <header class="cards" v-if="$can('analytics', 'campaign') || AuthenticatedUser.is_superadmin">
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
         <div class="datatable-scroll" v-if="$can('list', 'campaign') || AuthenticatedUser.is_superadmin">
            <table class="table campagins-table">
               <thead>
                  <tr class="row">
                     <td>Campaign name</td>
                     <td>Campaign status</td>
                     <td>Number of trackers</td>
                     <td>Created on</td>
                     <td>Created by</td>
                     <td class="text-center">Actions</td>
                  </tr>
               </thead>
               <tbody>
                  <tr v-for="campaign in campaigns.all" :key="campaign.id">
                     <td>
                        {{ campaign.name }}
                     </td>
                     <td>
                        <span :class="'status status-' + (campaign.status ? 'success' : 'danger')" :title="(campaign.status ? 'Enabled' : 'Disabled')"></span>
                     </td>
                     <td>
                        <p>{{ campaign.trackers_count }}</p>
                     </td>
                     <td>
                        <p>{{ moment(campaign.created_at).format('DD/MM/YYYY h:mm') }}</p>
                     </td>
                     <td>
                        <p>
                           <span class="badge badge-success">{{ campaign.user.name }}</span>
                        </p>
                     </td>
                     <td class="text-center">
                     <router-link  v-if="$can('analytics', 'campaign') || AuthenticatedUser.is_superadmin" v-show="campaign.trackers_count > 0" :to="{name : 'campaigns', params: {uuid: campaign.uuid}}" class="icon-link" title="Statistics">
                            <i class="far fa-chart-bar"></i>
                        </router-link>
                        <a v-if="$can('rename', 'campaign') || AuthenticatedUser.is_superadmin" href="javascript:void(0);" v-show="campaign.id" class="icon-link" title="Edit" @click="showEditCampaignModal(campaign)"><i class="fas fa-pen"></i></a>
                        <a v-if="$can('delete', 'campaign') || AuthenticatedUser.is_superadmin" href="javascript:void(0);" class="icon-link" title="Delete" @click="deleteCampaign(campaign)"><i class="fas fa-trash"></i></a>
                     </td>
                  </tr>
               </tbody>
            </table>
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
export default {
   components: {
      CreateCampaignModal,
      CampaignAnalytics
   },
   data() {
      return {
         showAddCampaignModal: false,
         isLoading: true
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

         this.isLoading = false;
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