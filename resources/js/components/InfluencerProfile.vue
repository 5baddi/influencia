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
             <a :href="status.link" target="_blank" @mouseover="attrActive=status.id" @mouseleave="attrActive=null" class="influencer-posts-card" v-for="status in influencer.posts" :key="status.id">
               <img :src="status.thumbnail_url" loading="lazy"/>
               <i v-if="status.type === 'video' || status.type === 'sidecar'" :class="'influencer-posts-card-type fas fa-' + (status.type === 'sidecar' ? 'images' : 'video')"></i>
               <div :class="'influencer-posts-card-attr ' + (attrActive === status.id ? ' active' : '')">
                  <i class="fas fa-heart"></i>{{ nbr().abbreviate(status.likes) }}
                  <i class="fas fa-comment"></i>{{ nbr().abbreviate(status.comments) }}
               </div>
             </a>
          </div>
      </div>
</template>
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
   },
   data(){
       return {
            attrActive: null,
       }
   }
}
</script>