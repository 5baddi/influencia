<template>
   <div class="campaigns">
      <div class="hero">
         <div class="hero__intro">
            <h1>Campagins</h1>
            <ul class="breadcrumbs">
               <li>
                  <a href="#">Dashboard</a>
               </li>
               <li>
                  <a href="#">Campaigns</a>
               </li>
            </ul>
         </div>
         <div class="hero__actions">
            <button
               :disabled="!activeBrand"
               class="btn btn-success"
               @click="showAddCampaignModal = !showAddCampaignModal"
            >Add new campagin</button>
         </div>
      </div>
      <div class="p-1">
         <header class="cards">
            <div class="card">
               <div class="number">{{ (campaigns && campaigns.length > 0) ? campaigns.length : 0 }}</div>
               <p class="description">NUMBER OF CAMPAIGNS</p>
            </div>
            <!-- <div class="card">
               <div class="number">{{ (campagins.trackers_count && campaigns.trackers_count > 0) ? trackers.length : 0 }}</div>
               <p class="description">NUMBER OF TRACKERS</p>
            </div> -->
            <div class="card">
               <div class="number">4 933 424</div>
               <p class="description">TOTAL ESTIMATED IMPRESSIONS</p>
            </div>
            <div class="card">
               <div class="number">2 893 283</div>
               <p class="description">TOTAL SIZE OF ACTIVATED COMMUNITIES</p>
            </div>
         </header>
         <div class="datatable-scroll">
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
                  <tr v-for="campaign in campaigns" :key="campaign.id">
                     <td>
                        {{ campaign.name }}
                     </td>
                     <td>
                        <p>
                           <span class="status status-success" v-if="campaign.status"></span>
                           <span class="status status-danger" v-else></span>
                        </p>
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
                        <router-link :to="{name : 'campagins', params: {uuid: campaign.uuid}}" class="icon-link" title="Statistics">
                            <i class="far fa-chart-bar"></i>
                        </router-link>
                        <a href="javascript:void(0);" v-show="campaign.id" class="icon-link" title="Edit" @click="showEditCampaignModal(campaign)"><i class="fas fa-pen"></i></a>
                        <a href="javascript:void(0);" class="icon-link" title="Delete"><i class="fas fa-trash"></i></a>
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
       next(vm => vm.initData())
   },
   // beforeRouteUpdate(to, from, next){
   //     let routeUUID = to.params.uuid
   //     if(typeof routeUUID !== 'undefined' && (this.campaign !== null && this.campaign.uuid !== routeUUID)){
   //         this.$store.commit("setCampaign", {campaign: null})
   //         this.fetchCampaign()
   //     }

   //     next()
   // },
   // created(){
   //    this.initData();
   // },
   // watch: {
   //    $route: "initData"
   // },
   methods: {
      initData(){
         this.$store.dispatch("fetchCampaigns");
         // this.$store.dispatch("fetchTrackers");

         // this.fetchInfluencer();

         this.isLoading = false;
      },
      // fetchCampaign(){
      //    // Load user by UUID
      //    if(typeof this.$route.params.uuid !== 'undefined')
      //          this.$store.dispatch("fetchCamapaign", this.$route.params.uuid);
      //    else
      //          this.$store.commit("setCampaign", {campaign: null});
      // },
      moment() {
         return moment();
      },
      // dismissAddCampaignModal() {
      //    this.showAddCampaignModal = false;
      // },
      // showEditCampaignModal(){

      // },
      // create(payload) {
      //    payload = {
      //       ...payload,
      //       brand_id: this.$store.getters.activeBrand && this.$store.getters.activeBrand.id
      //    };
      //    this.$store.dispatch("addNewCampaign", payload).then(() => {
      //       this.createCampaignSuccess({ message: "Campaign created successfully" });
      //       this.dismissAddCampaignModal();
      //    });
      // }
   },
   computed: {
      ...mapGetters(["activeBrand", "campaigns", "campaign"])
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