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
               <div class="number">{{ (campaigns.all && campaigns.all.length) ? campaigns.all.length : 0 }}</div>
               <p class="description">NUMBER OF CAMPAIGNS</p>
            </div>
            <div class="card">
               <div class="number">{{ (trackers && trackers.length) ? trackers.length : 0 }}</div>
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
         <div class="datatable-scroll" v-if="$can('list', 'tracker') || AuthenticatedUser.is_superadmin">
            <DataTable ref="trackerssDT" :columns="columns" fetchMethod="fetchTrackers" responseField="all" cssClasses="table-card">
               <th slot="header">Actions</th>
               <!-- <td slot="body-row" slot-scope="row">

               </td> -->
            </DataTable>
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
export default {
   components: {
      CreateTrackerModal
   },
   data() {
      return {
         showAddTrackerModal: false,
         columns: [
            {
               name: "Name",
               field: "name"
            },
            {
               name: "Status",
               field: "status",
               callback: function(row){
                  return '<span class="status status-' + (row.status ? 'success' : 'danger') + '" title="' + (row.status ? 'Enabled' : 'Disabled') + '">' + row.queued + '</span>';
               }
            },
            {
               name: "Influencer",
               field: "influencer_id",
               callback: function(row){
                  return row.influencer!== null ? (row.influencer.name ? row.influencer.name : row.influencer.username) : '---';
               }
            },
            {
               name: "Meduim",
               field: "platform",
               callback: function(row){
                  switch(row.platform){
                     case "instagram":
                        return '<i class="fab fa-2 fa-instagram" title="' + row.platform + '"></i>';
                     break;
                     default:
                        return '<i class="fab fa-2 fa-globe" title="' + row.type + '"></i>';
                     break;
                  }
               }
            },
            {
               name: "Created at",
               field: "created_at",
               isData: true,
               format: "DD/MM/YYYY"
            }
         ]
      };
   },
   created(){
      // Fetch brand compaigns
      this.$store.dispatch("fetchCampaigns");
      // Fetch brand trackers
      // this.$store.dispatch("fetchTrackers");
   },
   computed:{
      ...mapGetters(["AuthenticatedUser", "campaigns", "trackers"])
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
      showEditTrackerModal(){

      },
      create(payload) {
         let data = payload.data;
         let formData = new FormData();

         // Set base tracker info
         formData.append("user_id", data.user_id);
         formData.append("campaign_id", data.campaign_id);
         formData.append("name", data.name);
         formData.append("type", data.type);
         if(data.type !== 'url')
            formData.append("platform", data.platform);


         // Create story tracker
         if(data.type === "story"){
            // Append form data
            formData.append("username", data.username);
            Array.from(data.story).forEach(file => {
               formData.append("story[]", file);
            });
         }else{
            formData.append("url", data.url);
         }

         // Dispatch the creation action
         this.$store.dispatch("addNewTracker", formData)
            .then(response => {
               this.dismissAddTrackerModal();
               this.createTrackerSuccess({ message: `Tracker ${response.content.name} created successfuly!` });
            })
            .catch(error => {
               this.createTrackerErrors({ title: "Error", message: `${error.message}` });
               // error.errors.map((v, i) => {
               //    console.log(v);
               // });
            });
      }
   }
};
</script>