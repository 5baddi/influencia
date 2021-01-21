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
                <router-link class="btn btn-success" :disabled="!activeBrand" :to="{name: 'new_story'}">
                    <i class="fas fa-plus"></i>&nbsp;Add new story    
                </router-link>
            </div>
        </div>
        <div class="influencer">
            <div class="influencer-posts">
                <a :href="story.link || '#'" target="_blank" @mouseover="attrActive=story.uuid" @mouseleave="attrActive=null" class="influencer-posts-card" v-for="story in fetchedStories" :key="story.uuid">
                    <img :src="story.thumbnail" loading="lazy"/>
                    <span class="influencer-posts-card-type">
                        <i v-if="story.type === 'video'" :class="'fas fa-' + (story.type === 'image' ? 'images' : 'video')"></i>
                        <i v-if="story.influencer.platform === 'instagram'" class="fab fa-2 fa-instagram instagram-icon"></i>
                    </span>
                    <div :class="'influencer-posts-card-attr ' + (attrActive === story.uuid ? ' active' : '')">
                        <a class="influencer-avatar" :href="story.influencer.platform === 'instagram' ? 'https://instagram.com/' + story.influencer.username : ''" :title="'View on ' + story.influencer.platform" target="_blank">
                            <img :src="story.influencer.pic_url" alt="Avatar"/>
                            {{ story.influencer.parsed_name }}
                        </a>
                        <router-link class="btn btn-success" :to="{name: 'new_story', params: {uuid: story.uuid}}">
                            <i class="far fa-chart-bar"></i>&nbsp;Enter insights   
                        </router-link>
                    </div>
                </a>
            </div>
            <div class="load-more">
                <button class="btn" @click="loadStories()" v-show="!loadingMore && page">Load more</button>
                <svg v-show="loadingMore" data-v-3b43fdf1="" class="svg-inline--fa fa-spinner fa-w-16 fa-spin" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="spinner" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z"></path></svg>
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
    .influencer-posts-card-attr{
        flex-direction: column;
    }
    .influencer-posts-card-attr .btn{
       font-size: 8pt;
        padding: 0.7rem;
        margin-top: 1rem;
    }
    .influencer-avatar{
        text-align: center;
        color: white;
        text-decoration: none;
    }
    .influencer-avatar img{
        display: block;
        max-width: 100px;
        max-height: 100px;
        border-radius: 50%;
        margin-bottom: 1rem;
    }
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
            this.loadingMore = true;

           this.$store.dispatch("fetchStories", {page: this.page})
            .then(response => {
                // Merge values and set mext page
                if(typeof response.content.items !== "undefined"){
                    this.fetchedStories = this.fetchedStories.concat(response.content.items);

                    if(response.content.pagination && response.content.pagination.lastPage && response.content.pagination.currentPage)
                        this.page = response.content.pagination.currentPage < response.content.pagination.lastPage ? response.content.pagination.currentPage + 1 : null;
                }

                this.loadingMore = false;
            })
            .catch(error => {
                this.loadingMore = false;
            });
        }
    },
    mounted(){
        // Load stories
        if(typeof this.stories === "undefined" || this.stories === null || Object.values(this.stories).length === 0)
            this.loadStories();
    },
    data(){
       return {
            attrActive: null,
            page: null,
            loadingMore: true,
            fetchedStories: []
       }
   },
}
</script>