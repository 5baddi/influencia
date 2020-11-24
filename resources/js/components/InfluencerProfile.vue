<template>
    <div class="p-1" v-if="influencer">
          <div class="card influencer">
              <div class="influencer-details">
                <div class="influencer-details-picture">
                    <a :href="influencer.platform === 'instagram' ? 'https://instagram.com/' + influencer.username : ''" :title="'View on ' + influencer.platform" target="_blank"><img :src="influencer.pic_url" alt="Avatar"/></a>
                </div>
                <div class="influencer-details-name">
                    <h4>{{ influencer.name }}</h4>
                    <p>{{ influencer.biography ? influencer.biography : '&nbsp;' }}</p>
                    <ul>
                        <li v-if="influencer.website">
                            <a :href="influencer.website" target="_blank">
                                <i class="fas fa-globe"></i>
                                &nbsp;External website
                            </a>
                        </li>
                        <li>
                            <i class="fas fa-users"></i>
                            <span>{{ nbr().abbreviate(influencer.followers) }}</span>
                        </li>
                        <li>
                            <i class="fas fa-image"></i>
                            <span>{{ nbr().abbreviate(influencer.image_sequences) }}</span>
                        </li>
                        <li>
                            <i class="fas fa-images"></i>
                            <span>{{ nbr().abbreviate(influencer.carousel_sequences) }}</span>
                        </li>
                        <li>
                            <i class="fas fa-video"></i>
                            <span>{{ nbr().abbreviate(influencer.video_sequences) }}</span>
                        </li>
                        <li>
                            <i class="fas fa-heart"></i>
                            <span>{{ nbr().abbreviate(influencer.likes) }}</span>
                        </li>
                        <li>
                            <i class="fas fa-comments"></i>
                            <span>{{ nbr().abbreviate(influencer.comments) }}</span>
                        </li>
                    </ul>
                </div>
                <div class="influencer-details-bar">
                    <span class="influencer-details-bar-instagram" style="width:100%">
                        <i class="fab fa-instagram"></i>&nbsp;{{ nbr().abbreviate(influencer.followers) }}
                    </span>
                </div>
              </div>
          </div>
          <div class="influencer-posts">
             <a :href="status.link" target="_blank" @mouseover="attrActive=status.id" @mouseleave="attrActive=null" class="influencer-posts-card" v-for="status in influencerContent" :key="status.id">
               <img :src="status.thumbnail_url" loading="lazy"/>
               <i v-if="status.type === 'video' || status.type === 'sidecar'" :class="'influencer-posts-card-type fas fa-' + (status.type === 'sidecar' ? 'images' : 'video')"></i>
               <div :class="'influencer-posts-card-attr ' + (attrActive === status.id ? ' active' : '')">
                  <i class="fas fa-heart"></i>{{ nbr().abbreviate(status.likes) }}
                  <i class="fas fa-comment"></i>{{ nbr().abbreviate(status.comments) }}
               </div>
             </a>
          </div>
          <div class="load-more">
            <button class="btn" @click="loadMore()" v-show="!loadingMore && page">Load more</button>
            <svg v-show="loadingMore" data-v-3b43fdf1="" class="svg-inline--fa fa-spinner fa-w-16 fa-spin" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="spinner" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z"></path></svg>
          </div>
      </div>
</template>
<style scoped>
    .load-more{
        display: flex;
        justify-content: center;
        margin: 1rem 0;
    }
    .load-more .btn{
        background-color: #039be5;
        color: white;
    }
    .load-more .btn:hover, btn:focus{
        opacity: 0.7;
    }
    .load-more svg{
        font-size: 22pt;
        color: #039be5;
    }
</style>
<script>
import abbreviate from 'number-abbreviate';

export default {
   props: {
       influencer: {
           type: Object,
           default: () => ({
               pic_url: {
                   type: String,
                   default: null
               },
               name: {
                   type: String,
                   default: null
               },
               biography: {
                   type: String,
                   default: null
               },
               followers: {
                   type: Number,
                   default: 0
               },
               posts: {
                   type: Array,
                   default: []
               }
           })
       }
   },
   methods: {
       nbr(){
           return new abbreviate();
       },
       loadMore(){
           this.loadingMore = true;

           this.$store.dispatch("fetchInfluencerContent", {uuid: this.influencer.uuid, page: this.page})
            .then(response => {
                // Merge values and set mext page
                if(typeof response.content.data !== "undefined"){
                    this.influencerContent = this.influencerContent.concat(response.content.data);

                    if(response.content.to && response.content.total)
                        this.page = response.content.to < response.content.total ? this.page + 1 : null;
                }

                this.loadingMore = false;
            })
            .catch(error => {
                this.loadingMore = false;
            });
       }
   },
   data(){
       return {
            attrActive: null,
            page: 1,
            loadingMore: true,
            influencerContent: []
       }
   },
   created(){
       this.loadMore();
   }
}
</script>