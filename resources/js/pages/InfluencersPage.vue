<template>
   <div class="influencers" v-if="!isLoading">
      <div class="hero" v-if="!influencer">
         <div class="hero__intro">
            <h1>Influencers</h1>
            <ul class="breadcrumbs">
               <li>
                  <router-link :to="{name: 'dashboard'}">Dashboard</router-link>
               </li>
               <li>
                  <a href="#">Influencers</a>
               </li>
            </ul>
         </div>
      </div>
      <div class="p-1" v-if="!influencer">
         <header class="cards">
            <div class="card">
               <div class="number">{{ (influencers && influencers.length ) ? influencers.length : 0 }}</div>
               <p class="description">NUMBER OF INFLUENCERS</p>
            </div>
         </header>
         <div class="datatable-scroll">
            <DataTable :columns="columns" fetchMethod="fetchInfluencers" cssClasses="table-card">
               <th slot="header">Actions</th>
               <td slot="body-row" slot-scope="row">
                  <router-link v-if="row.data.queued === 'finished'" :to="{name : 'influencers', params: {uuid: row.data.uuid}}" class="icon-link" title="Details">
                     <i class="fas fa-eye"></i>
                  </router-link>
                  <!-- <a href="javascript:void(0);" class="icon-link" title="Edit" @click="showEditInfluencerModal(row.data)"><i class="fas fa-pen"></i></a>
                  <a href="javascript:void(0);" class="icon-link" title="Delete"><i class="fas fa-trash"></i></a> -->
               </td>
            </DataTable>
         </div>
      </div>
      <InfluencerProfile v-if="influencer" :influencer="influencer"/>
      <EditInfluencerModal v-if="editInfluencerModal" :influencer="influencer"/>
   </div>
</template>
<script>
import InfluencerProfile from "../components/InfluencerProfile";
import EditInfluencerModal from "../components/modals/EditInfluencerModal";
import { mapGetters } from "vuex";
import moment from "moment";
import abbreviate from 'number-abbreviate';

export default {
   components: {
      InfluencerProfile,
      EditInfluencerModal
   },
   data() {
      return {
         isLoading: true,
         editInfluencerModal: false,
         columns: [
            {
               field: "pic_url",
               callback: function(row){
                  return '<img src="' + row.pic_url + '"/>';
               },
               sortable: false
            },
            {
               name: "Full name",
               field: "name",
               callback: function(row){
                  return row.name ? row.name : row.username;
               }
            },
            {
               name: "Followers",
               field: "followers"
            },
            {
               name: "Posts",
               field: "posts"
            },
            {
               name: "Platform",
               field: "platform",
               callback: function(row){
                  let link = "";
                  let icon = "";

                  if(row.platform === "instagram"){
                     link = "https://instagram.com/" + row.username;
                     icon = "<i class=\"fab fa-instagram\"></i>";
                  }

                  return '<a href="' + link + '" target="_blank" title="' + row.platform + '">' + icon + '</a>';
               }
            },
            {
               name: "Added at",
               field: "created_at",
               callback: function(row){
                  return moment(row.created_at).format('DD/MM/YYYY');
               }
            }
         ]
      };
   },
   beforeRouteEnter(to, from, next){
       next(vm => vm.initData())
   },
   beforeRouteUpdate(to, from, next){
       let routeUUID = to.params.uuid
       if(typeof routeUUID !== 'undefined' && (this.influencer !== null && this.influencer.uuid !== routeUUID)){
           this.$store.commit("setInfluencer", {influencer: null})
           this.fetchInfluencer()
       }

       next()
   },
   created(){
      this.initData();
   },
   watch: {
       '$route': 'initData'
   },
   methods: {
      test(row){
         console.log(row);
      },
      dismissEditInfluencerModal(){
         this.editInfluencerModal = false;
      },
      showEditInfluencerModal(influencer){
         this.editInfluencerModal = true;
      },
       nbr(){
           return new abbreviate();
       },
      fetchInfluencer(){
         // Load user by UUID
         if(typeof this.$route.params.uuid !== 'undefined')
               this.$store.dispatch("fetchInfluencer", this.$route.params.uuid);
         else
               this.$store.commit("setInfluencer", {influencer: null});
      },
      initData(){
         if(!this.$store.getters.influencers){
            this.$store.dispatch("fetchInfluencers").then(response => {
                  this.isLoading = false;
            });
         }

         this.fetchInfluencer();

         this.isLoading = false;
      },
      moment() {
         return moment();
      }
   },
   computed: {
      ...mapGetters(["influencers", "influencer"])
   },
};
</script>