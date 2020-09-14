<template>
   <div class="campaigns" v-if="!isLoading">
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
               <div class="number">{{ campaigns.length }}</div>
               <p class="description">NUMBER OF CAMPAIGNS</p>
            </div>
            <div class="card">
               <div class="number">34</div>
               <p class="description">NUMBER OF TRACKERS</p>
            </div>
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
                     <td>Actions</td>
                  </tr>
               </thead>
               <tbody>
                  <tr v-for="campaign in campaigns" :key="campaign.id">
                     <td>
                        <a href="#">{{ campaign.name }}</a>
                     </td>
                     <td>
                        <p>
                           <span class="status-success" v-if="campaign.status"></span>
                           <span class="status-danger" v-else></span>
                        </p>
                     </td>
                     <td>
                        <p>0</p>
                     </td>
                     <td>
                        <p>{{ moment(campaign.created_at).format('DD/MM/YYYY h:mm') }}</p>
                     </td>
                     <td>
                        <p>
                           <span class="badge badge-success">{{ campaign.user.name }}</span>
                        </p>
                     </td>
                     <td></td>
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
   </div>
</template>
<script>
import CreateCampaignModal from "../components/modals/CreateCampaignModal";
import { mapGetters } from "vuex";
import moment from "moment";
export default {
   components: {
      CreateCampaignModal
   },

   data() {
      return {
         showAddCampaignModal: false,
         isLoading: true
      };
   },
   created() {
      this.$store.dispatch("fetchCampaigns").then(() => {
         this.isLoading = false;
      });
   },
   methods: {
      moment() {
         return moment();
      },
      dismissAddCampaignModal() {
         this.showAddCampaignModal = false;
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
      }
   },
   computed: {
      ...mapGetters(["activeBrand", "campaigns"])
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
<style scoped>
span.status-success {
   background: #09d260;
   width: 10px;
   height: 10px;
   display: block;
   border-radius: 50%;
}
</style>