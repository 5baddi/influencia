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
               <div class="number">2</div>
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
                     <td>Tracker name</td>
                     <td>Tracker status</td>
                     <td>Tracker influencer</td>
                     <td>Tracker meduim</td>
                     <td>Created on</td>
                     <td>Actions</td>
                  </tr>
               </thead>
               <tbody>
                  <tr>
                     <td>
                        <p>#tracker</p>
                     </td>
                     <td>
                        <p>active</p>
                     </td>
                     <td>
                        <p>-</p>
                     </td>
                     <td>
                        <p>06/07/2020 09:21</p>
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
import { mapGetters } from 'vuex';
import CreateTrackerModal from "../components/modals/CreateTrackerModal";
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
      if(!this.$store.getters.campaigns){
         this.$store.dispatch("fetchCampaigns");
      }
   },
   computed:{
      ...mapGetters(["campaigns"])
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