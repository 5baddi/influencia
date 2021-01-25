<template>
    <div class="p-1" v-if="influencer">
          <div class="card influencer">
              <div class="influencer-details">
                <div class="influencer-details-picture">
                    <a :href="influencer.platform === 'instagram' ? 'https://instagram.com/' + influencer.username : ''" :title="'View on ' + influencer.platform" target="_blank"><img :src="influencer.pic_url" alt="Avatar"/></a>
                </div>
                <div class="influencer-details-name">
                    <h4>
                        {{ influencer.name }}
                        <svg v-if="influencer.is_verified" title="Verified account" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="badge-check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-badge-check fa-w-16"><path fill="currentColor" d="M512 256c0-37.7-23.7-69.9-57.1-82.4 14.7-32.4 8.8-71.9-17.9-98.6-26.7-26.7-66.2-32.6-98.6-17.9C325.9 23.7 293.7 0 256 0s-69.9 23.7-82.4 57.1c-32.4-14.7-72-8.8-98.6 17.9-26.7 26.7-32.6 66.2-17.9 98.6C23.7 186.1 0 218.3 0 256s23.7 69.9 57.1 82.4c-14.7 32.4-8.8 72 17.9 98.6 26.6 26.6 66.1 32.7 98.6 17.9 12.5 33.3 44.7 57.1 82.4 57.1s69.9-23.7 82.4-57.1c32.6 14.8 72 8.7 98.6-17.9 26.7-26.7 32.6-66.2 17.9-98.6 33.4-12.5 57.1-44.7 57.1-82.4zm-144.8-44.25L236.16 341.74c-4.31 4.28-11.28 4.25-15.55-.06l-75.72-76.33c-4.28-4.31-4.25-11.28.06-15.56l26.03-25.82c4.31-4.28 11.28-4.25 15.56.06l42.15 42.49 97.2-96.42c4.31-4.28 11.28-4.25 15.55.06l25.82 26.03c4.28 4.32 4.26 11.29-.06 15.56z" class=""></path></svg>
                    </h4>
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
                            <span>{{ influencer.followers | formatedNbr }}</span>
                        </li>
                        <li v-if="influencer.image_sequences > 0">
                            <i class="fas fa-image"></i>
                            <span>{{ influencer.image_sequences | formatedNbr }}</span>
                        </li>
                        <li v-if="influencer.carousel_sequences > 0">
                            <i class="fas fa-images"></i>
                            <span>{{ influencer.carousel_sequences | formatedNbr }}</span>
                        </li>
                        <li v-if="influencer.video_sequences > 0">
                            <i class="fas fa-video"></i>
                            <span>{{ influencer.video_sequences | formatedNbr }}</span>
                        </li>
                        <li v-if="influencer.likes > 0">
                            <i class="fas fa-heart"></i>
                            <span>{{ influencer.likes | formatedNbr }}</span>
                        </li>
                        <li v-if="influencer.comments > 0">
                            <i class="fas fa-comments"></i>
                            <span>{{ influencer.comments | formatedNbr }}</span>
                        </li>
                    </ul>
                </div>
                <div class="influencer-details-bar">
                    <span :class="'influencer-details-bar-' + influencer.platform" style="width:100%">
                        <i class="fab fa-instagram"></i>&nbsp;{{ influencer.followers | formatedNbr }}
                    </span>
                </div>
              </div>
          </div>
          <div class="influencer-posts">
             <a :href="status.link" target="_blank" @mouseover="attrActive=status.id" @mouseleave="attrActive=null" class="influencer-posts-card" v-for="status in influencerContent" :key="status.id">
               <img :src="status.thumbnail_url" loading="lazy"/>
               <i v-if="status.type === 'video' || status.type === 'sidecar'" :class="'influencer-posts-card-type fas fa-' + (status.type === 'sidecar' ? 'images' : 'video')"></i>
               <div :class="'influencer-posts-card-attr ' + (attrActive === status.id ? ' active' : '')">
                    <i class="fas fa-heart"></i>{{ status.likes | formatedNbr }}
                    <i class="fas fa-comment"></i>{{ status.comments | formatedNbr }}
               </div>
             </a>
          </div>
          <p class="scraping-alert" v-if="influencer.medias > 0 && influencerContent.length === 0">Please wait until analyze all media...</p>
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
    .scraping-alert{
        text-align: center;
        color: grey;
        font-weight: bold;
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
       loadMore(){
           this.loadingMore = true;

           this.$store.dispatch("fetchInfluencerContent", {uuid: this.influencer.uuid, page: this.page})
            .then(response => {
                // Merge values and set mext page
                if(typeof response.content.data !== "undefined"){
                    this.influencerContent = this.influencerContent.concat(response.content.data);

                    if(response.content.to && response.content.total && response.content.current_page)
                        this.page = response.content.to < response.content.total ? response.content.current_page + 1 : null;
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
            page: null,
            loadingMore: true,
            influencerContent: []
       }
   },
   created(){
       this.loadMore();
   }
}
</script>