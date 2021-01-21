<template>
    <div class="listing">
        <div class="hero">
            <div class="hero__intro">
                <h1>Stories</h1>
                <ul class="breadcrumbs">
                    <li>
                        <a href="#">Dashboard</a>
                    </li>
                    <li>
                        <a href="#">Stories</a>
                    </li>
                </ul>
            </div>
            <div class="hero__actions" v-if="($can('create', 'tracker') || (AuthenticatedUser && AuthenticatedUser.is_superadmin))">
                <button :disabled="!activeBrand" class="btn btn-success" @click="addStory()">Add new story</button>
            </div>
        </div>
        <div class="influencer">
            <div class="influencer-posts">
                <a :href="story.link || '#'" target="_blank" @mouseover="attrActive=story.uuid" @mouseleave="attrActive=null" class="influencer-posts-card" v-for="story in stories.items" :key="story.uuid">
                    <img :src="story.thumbnail" loading="lazy"/>
                    <span class="influencer-posts-card-type">
                        <i v-if="story.type === 'video'" :class="'fas fa-' + (story.type === 'image' ? 'images' : 'video')"></i>
                        <i v-if="story.influencer.platform === 'instagram'" class="fab fa-2 fa-instagram instagram-icon"></i>
                    </span>
                    <div :class="'influencer-posts-card-attr ' + (attrActive === story.uuid ? ' active' : '')">
                         <a :href="story.influencer.platform === 'instagram' ? 'https://instagram.com/' + story.influencer.username : ''" :title="'View on ' + story.influencer.platform" target="_blank"><img :src="story.influencer.pic_url" alt="Avatar"/></a>
                    </div>
                </a>
            </div>
        </div> 
    </div>
</template>
<style scoped>
    .influencer{
        padding: 0;
        margin: 1rem;
    }
    .influencer-posts{
        margin: 0 !important;
    }
</style>
<script>
import {mapGetters} from 'vuex';

export default {
    computed: {
        ...mapGetters(["AuthenticatedUser", "stories"]),
        activeBrand(){
            if(this.AuthenticatedUser !== null && typeof this.AuthenticatedUser !== "undefined" && this.AuthenticatedUser.selected_brand)
                return this.AuthenticatedUser.selected_brand;

            return null;
        }
    },
    methods: {
        loadStories() {            
            // Load stories
            if(Object.values(this.stories).length === 0)
                this.$store.dispatch("fetchStories").catch(error => {});
        },
        addStory(){

        }
    },
    mounted(){
        // Load stories
        if(typeof this.stories === "undefined" || this.stories === null || Object.values(this.stories).length === 0)
            this.loadStories();
    },
    data(){
       return {
            attrActive: null
       }
   },
}
</script>