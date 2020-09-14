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
   methods: {
      dismissAddTrackerModal() {
         this.showAddTrackerModal = false;
      },
      create(payload) {
         console.log("payload", payload);
      }
   }
};
</script>