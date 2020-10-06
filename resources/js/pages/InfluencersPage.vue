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
         <div class="hero__actions">
            <button class="btn btn-success" @click="showAddInfluencerModal = !showAddInfluencerModal" disabled>Add new Influencer</button>
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
                        <p>{{ nbr().abbreviate(influencer.followers, 0) }}</p>
                     </td>
                     <td>
                        <p>{{ influencer.posts }}</p>
                     </td>
                     <td class="text-center">
                        <a :href="'https://instagram.com/' + influencer.username" target="_blank" v-if="influencer.network === 'instagram'">
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
      <div class="p-1" v-if="influencer">
          <div class="card influencer">
              <div class="influencer-details">
                <div class="influencer-details-picture">
                    <img :src="influencer.pic_url" alt="Avatar"/>
                </div>
                <div class="influencer-details-name">
                    <h4>{{ influencer.name }}</h4>
                    <p>{{ influencer.biography }}</p>
                </div>
                <div class="influencer-details-bar">
                    <span class="influencer-details-bar-instagram" style="width:100%">
                        <i class="fab fa-instagram"></i>&nbsp;{{ nbr().abbreviate(influencer.followers) }}
                    </span>
                </div>
              </div>
          </div>
          <div class="influencer-posts">
             <div @mouseover="attrActive='active'" @mouseleave="attrActive=''" class="influencer-posts-card" v-for="status in influencer.statues" :key="status.id">
               <img :src="status.thumbnail_url" loading="lazy"/>
               <div :class="'influencer-posts-card-attr ' + attrActive">
                  <i class="fas fa-heart"></i>{{ status.likes }}
                  <i class="fas fa-comment"></i>{{ status.comments }}
               </div>
             </div>
          </div>
      </div>
      <CreateInfluencerModel :show="showAddInfluencerModal" @dismiss="dismissAddInfluencerModal" />
   </div>
</template>
<script>
import CreateInfluencerModel from "../components/modals/CreateInfluencerModel";
import { mapGetters } from "vuex";
import moment from "moment";
import abbreviate from 'number-abbreviate';

export default {
   components: {
      CreateInfluencerModel
   },
   data() {
      return {
         showAddInfluencerModal: false,
         isLoading: true,
         attrActive: '',
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
      },
      dismissAddInfluencerModal(id) {
         this.showAddInfluencerModal = false;
         this.brand = {};
      }
   },
   computed: {
      ...mapGetters(["influencers", "influencer"])
   },
};
</script>