<template>
   <div class="trackers">
      <div class="hero">
         <div class="hero__intro">
            <h1>Trackers</h1>
            <ul class="breadcrumbs">
               <li>
                  <a href="#">Dashboard</a>
               </li>
               <li>
                  <a href="#">Trackers</a>
               </li>
            </ul>
         </div>
         <div class="hero__actions">
            <button
               class="btn btn-success"
               @click="showAddTrackerModal = !showAddTrackerModal"
            >Add new Trackers</button>
         </div>
      </div>
      <div class="p-1">
         <header class="cards">
            <div class="card">
               <div class="number">{{ campaigns ? campaigns.length : 0 }}</div>
               <p class="description">NUMBER OF CAMPAIGNS</p>
            </div>
            <div class="card">
               <div class="number">{{ trackers ? trackers.length : 0 }}</div>
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
                     <td>Tracker name</td>
                     <td>Tracker status</td>
                     <td>Tracker influencer</td>
                     <td>Tracker meduim</td>
                     <td>Created on</td>
                     <td>Actions</td>
                  </tr>
               </thead>
               <tbody>
                  <tr v-for="tracker in trackers" :key="tracker.id">
                     <td>
                        <p>{{ tracker.name }}</p>
                     </td>
                     <td>
                        <p>
                           <span class="status-success" v-if="tracker.status"></span>
                           <span class="status-danger" v-else></span>
                        </p>
                     </td>
                     <td>
                        <p>{{ tracker.username ? tracker.username : '---' }}</p>
                     </td>
                     <td>
                        <p>{{ moment(tracker.created_at).format('DD/MM/YYYY h:mm') }}</p>
                     </td>
                     <td></td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
      <CreateTrackerModal
         :show="showAddTrackerModal"
         @create="create"
         @dismiss="dismissAddTrackerModal"
      />
   </div>
</template>
<script>
import { mapGetters } from "vuex";
import CreateTrackerModal from "../components/modals/CreateTrackerModal";
import moment from "moment";
export default {
   components: {
      CreateTrackerModal
   },
   data() {
      return {
         showAddTrackerModal: false
      };
   },
   created(){
      // Fetch brand compaigns
      this.$store.dispatch("fetchCampaigns");
      // Fetch brand trackers
      this.$store.dispatch("fetchTrackers");
   },
   computed:{
      ...mapGetters(["campaigns", "trackers"])
   },
   notifications: {
      createTrackerErrors: {
         type: "error"
      },
      createTrackerSuccess: {
         type: "success"
      }
   },
   methods: {
      moment(){
         return moment();
      },
      dismissAddTrackerModal() {
         this.showAddTrackerModal = false;
      },
      create(payload) {
         let data = payload.data;
         let formData = new FormData();

         // Set base tracker info
         formData.append("user_id", data.user_id);
         formData.append("campaign_id", data.campaign_id);
         formData.append("name", data.name);
         formData.append("type", data.type);

         // Create story tracker
         if(data.type === "story"){
            // Append form data
            formData.append("username", data.username);
            formData.append("story", data.story);
         }else{
            formData.append("url", data.url);
         }

         // Dispatch the creation action
         this.$store.dispatch("addNewTracker", formData)
            .then(response => {
               this.dismissAddTrackerModal();
               this.createTrackerSuccess({ message: `Tracker ${response.data.name} created successfuly!` });
            })
            .catch(error => {
               this.createTrackerErrors({ title: "Error", message: `${error.response.data.message}` });
            });
      }
   }
};
</script>