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
        <div class="p-1 influencer">
            <div class="influencer-posts">
                <a :href="story.link || '#'" target="_blank" @mouseover="attrActive=story.uuid" @mouseleave="attrActive=null" class="influencer-posts-card" v-for="story in stories.items" :key="story.uuid">
                    <img :src="story.thumbnail" loading="lazy"/>
                    <i v-if="story.type === 'video'" :class="'influencer-posts-card-type fas fa-' + (story.type === 'image' ? 'images' : 'video')"></i>
                    <div :class="'influencer-posts-card-attr ' + (attrActive === story.uuid ? ' active' : '')">
                        
                    </div>
                </a>
            </div>
        </div> 
    </div>
</template>
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