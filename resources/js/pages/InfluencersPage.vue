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
            <table class="table table-with-profile">
               <thead>
                  <tr class="row">
                     <td>&nbsp;</td>
                     <td>Full name</td>
                     <td>Followers</td>
                     <td>Posts</td>
                     <td class="text-center">Platform</td>
                     <td>Added at</td>
                     <td class="text-center">Actions</td>
                  </tr>
               </thead>
               <tbody>
                  <tr v-show="influencers.length > 0" v-for="influencer in influencers" :key="influencer.id">
                     <td>
                        <img :src="influencer.pic_url"/>
                     </td>
                     <td>
                        <p>{{ influencer.name ? influencer.name : influencer.username }}</p>
                     </td>
                     <td>
                        <p>{{ nbr().abbreviate(influencer.followers) }}</p>
                     </td>
                     <td>
                        <p>{{ nbr().abbreviate(influencer.posts) }}</p>
                     </td>
                     <td class="text-center">
                        <a :href="'https://instagram.com/' + influencer.username" target="_blank" v-if="influencer.platform === 'instagram'" :title="influencer.platform">
                           <i class="fab fa-instagram"></i>
                        </a>
                     </td> 
                     <td>
                        <p>{{ moment(influencer.created_at).format('DD/MM/YYYY') }}</p>
                     </td>
                     <td class="text-center">
                        <router-link :to="{name : 'influencers', params: {uuid: influencer.uuid}}" class="icon-link" title="Details">
                            <i class="fas fa-eye"></i>
                        </router-link>
                        <!-- <a href="javascript:void(0);" class="icon-link" title="Edit" @click="showEditInfluencerModal(influencer)"><i class="fas fa-pen"></i></a> -->
                        <a href="javascript:void(0);" class="icon-link" title="Delete"><i class="fas fa-trash"></i></a>
                     </td>
                  </tr>
                  <tr v-show="!influencers || influencers.length == 0">
                     <td colspan="7">
                        <p class="info">Looks like you don't have a influencer record, start creating one.</p>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
      <InfluencerProfile v-if="influencer" :influencer="influencer"/>
   </div>
</template>
<script>
import InfluencerProfile from "../components/InfluencerProfile";
import { mapGetters } from "vuex";
import moment from "moment";
import abbreviate from 'number-abbreviate';

export default {
   components: {
      InfluencerProfile
   },
   data() {
      return {
         isLoading: true,
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