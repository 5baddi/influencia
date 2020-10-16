<template>
   <div class="search">
      <div class="hero">
         <div class="hero__intro">
            <h1>Search</h1>
            <ul class="breadcrumbs">
               <li>
                  <a href="#">Dashboard</a>
               </li>
               <li>
                  <a href="#">Search</a>
               </li>
            </ul>
         </div>
      </div>
      <div class="p-1">
         <div class="card">
            <h2>Search @username, #hashtag, Keyword ...</h2>
            <p>Example: @alexia_mori__</p>
            <div class="searchform">
               <form>
                  <div class="control">
                     <input v-model="query" type="text" placeholder="Search ..." required />
                     <button class="btn" @click.prevent="search">
                        <svg width="24" height="24" viewBox="0 0 24 24" class="sc-fzoant dBHRFd">
                           <g fill="none" fill-rule="evenodd">
                              <circle cx="12" cy="12" r="12" />
                              <path
                                 fill="#000"
                                 fill-rule="nonzero"
                                 d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0016 9.5 6.5 6.5 0 109.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"
                              />
                           </g>
                        </svg>
                     </button>
                  </div>
               </form>
            </div>
         </div>
         <div class="results" v-if="result">
            <div class="card" v-if="result.type == 'user'">
               <h2>Result for {{ query }}</h2>
               <div class="influencer">
                  <div class="avatar">
                     <img :src="result.profile_pic_url"/>
                  </div>
                  <div class="meta">
                     <h3>{{ result.name }}</h3>
                     <p>{{ result.username}}</p>
                     <p v-show="!!result.biography">
                        <strong>Biography:</strong>
                        {{result.biography}}
                     </p>
                     <p v-show="!!result.website">
                        <strong>Website:</strong><a :href="result.website">{{ result.website }}</a>
                     </p>
                     <p>
                        <strong>Business account:</strong>
                        {{ result.is_business_account }}
                     </p>
                     <p>
                        <strong>Verified account:</strong>
                        {{ result.is_verified }}
                     </p>
                     <p>
                        <strong>Number of followers:</strong>
                        {{ result.edge_followed_by }}
                     </p>
                     <p>
                        <strong>Follows:</strong>
                        {{ result.edge_follow }}
                     </p>
                     <p>
                        <strong>Number of posts:</strong>
                        {{ result.edge_owner_to_timeline_media }}
                     </p>
                  </div>
               </div>
               <h4>Latest posts</h4>
               <div class="feed">
                  <div class="post" v-for="(post , index) in result.posts" :key="index">
                     <img :src="post.display_url" alt />
                     <p>{{ post.edge_media_to_caption }}</p>
                     <p>
                        <strong>Comments:</strong>
                        {{ post.edge_media_to_comment }}
                     </p>
                     <p>
                        <strong>Likes:</strong>
                        {{ post.edge_liked_by.count }}
                     </p>
                  </div>
               </div>
            </div>
            <div class="card" v-if="result.type == 'tag'">
               <h2>Result for {{ query }}</h2>
               <div class="influencer">
                  <div class="avatar">
                     <img :src="result.profile_pic_url" alt />
                  </div>
                  <div class="meta">
                     <h3>{{ result.name }}</h3>
                     <p>
                        <strong>Hashtag to media count:</strong>
                        {{result.edge_hashtag_to_media_count}}
                     </p>
                     <p>
                        <strong>Related tags:</strong>
                        <ul>
                           <li v-for="(tag, index) in result.edge_hashtag_to_related_tags.edges" :key="index"><span class="badge badge-info" style="margin-bottom:.2rem;">#{{tag.node.name}}</span></li>
                        </ul>
                     </p>

                  </div>
               </div>

               <h4>Latest posts</h4>
               <div class="feed">
                  <div class="post" v-for="(post , index) in result.edge_hashtag_to_top_posts.edges" :key="index">
                        <img :src="post.node.display_url" alt />
                        <p>{{ post.node.edge_media_to_caption.edges[0].node.text }}</p>
                        <p>
                           <strong>Comments:</strong>
                           {{ post.node.edge_media_to_comment.count }}
                        </p>
                        <p>
                           <strong>Likes:</strong>
                           {{ post.node.edge_liked_by.count }}
                        </p>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</template>
<script>
import Vue from "vue";
export default {
   data() {
      return {
         query: "",
         result: null
      };
   },
   created() {},
   methods: {
      search() {
         this.$http
            .post("/api/search", {
               query: this.query
            })
            .then(response => {
               this.result = response.data;
            });
      }
   }
};
</script>
<style scoped>
.card {
   padding-top: 3rem;
   padding-bottom: 3rem;
}
.card h2 {
   text-align: center;
   color: rgba(0, 0, 0, 0.87);
   margin-bottom: 1.5rem;
   margin-top: 0;
}

.searchform {
   max-width: 600px;
   margin: 0 auto;
}

.searchform button {
   position: absolute;
   right: 0;
   top: 0;
}

.results {
   margin-top: 2rem;
}

.results .influencer {
   display: flex;
   align-items: flex-start;
}

.results .avatar {
   margin-right: 1rem;
}

.results h3 {
   margin-top: 0;
   margin-bottom: 0.2rem;
}

.results .avatar img {
   max-width: 200px;
}
.meta p {
   margin: 0.2rem 0;
}

.feed {
   display: flex;
   flex-wrap: wrap;
}

.feed .post {
   flex: 0 0 calc(50% - 4rem);
   margin: 2rem;
}

.feed .post p {
   font-size: 0.7rem;
}
</style>