<template>
   <div class="modal" :class="{'show-modal' : show}">
      <div class="modal-content">
         <header>
            <h4 class="heading">Add new Tracker</h4>
         </header>
         <div class="modal-form">
            <form enctype="multipart/form-data" ref="trackerForm" v-on:submit.prevent="saveTracker">
               <p class="modal-form__heading">What would you like to track?</p>
               <div class="radio-group">
                  <!-- <div class="radio-group__item" :class="{active: type === 'url'}">
                     <label for="url">
                        <input type="radio" id="url" value="url" v-model="type" :disabled="true" />
                        <span>Visits to a URL</span>
                        <p>Track the number of visits and the location of the users that clicked on a link. There is absolutely no code to add to the destination URL to allow tracking, so you can track any URL, even if it's not your site.</p>
                     </label>
                  </div> -->
                  <div class="radio-group__item" :class="{active: type === 'post'}">
                     <label for="post">
                        <input type="radio" id="post" value="post" v-model="type" />
                        <span>Interactions for a post on a blog or social media</span>
                        <p>Track the number of interactions for any public post on blogs or social media.</p>
                     </label>
                  </div>
                  <div class="radio-group__item" :class="{active: type === 'story'}">
                     <label for="story">
                        <input type="radio" id="story" value="story" v-model="type"/>
                        <span>Interactions for an Instagram or Snapchat story</span>
                        <p>Specify the metrics for a story and its content in order to include it in the aggregated statistics.</p>
                     </label>
                  </div>
               </div>

               <div class="forms">
                  <div class="form-url">
                     <div class="control">
                        <label>Tracker name</label>
                        <input v-model="name" type="text" placeholder="Name" />
                        <p>The tracker name is private. It's used in the tracker listing. If no name has been given, one will be automatically generated according to what is being tracked.</p>
                     </div>
                  </div>
                  <div class="form-url">
                     <div class="control">
                        <label>Assign to campaign</label>
                        <select v-model="campaign_id">
                           <option :value="null" selected>Select a campaign</option>
                           <option v-for="camp in campaigns" :value="camp.id" :key="camp.id">{{ camp.name }}</option>
                        </select>
                        <p>Assign tracker to a exists campaign</p>
                     </div>
                  </div>
                  <div class="form-url" v-show="type !== 'story'">
                     <div class="control">
                        <label>{{ type === 'url' ? 'Destination URL' : 'Post URL' }}</label>
                        <input v-if="type === 'url'" v-model="url" type="text" placeholder="https://" />
                        <vue-tags-input v-if="type === 'post'" v-model="url" :placeholder="'Add post URL'" :tags="urls" @tags-changed="newUrls => urls = newUrls"/>
                        <p v-show="type === 'url'">We will generate a shortened URL which will redirect to the destination URL and allow us to track the number and location of visits.</p>
                        <p v-show="type === 'post'">You can specify multiple post URLs on blogs or social media, one URL per line. Several trackers will then be created.</p>
                     </div>
                  </div>
                  <div class="form-url" v-show="type !== 'url'">
                     <div class="form-control">
                        <p class="modal-form__heading">Which platform was used to post the {{ type }}?</p>
                        <label for="instagram" class="instagram-radio">
                           <input type="radio" value="instagram" v-model="platform" :checked="platform === 'instagram'"/>
                           <span><i class="fab fa-instagram"></i>&nbsp;Instagram</span>
                        </label>
                        <!-- <label for="youtube" class="youtube-radio">
                           <input :disabled="true" type="radio" value="youtube" v-model="platform" :checked="platform === 'youtube'"/>
                           <span><i class="fab fa-youtube"></i>&nbsp;YouTube</span>
                        </label> -->
                        <!-- <label for="snapchat" class="snapchat-radio">
                           <input type="radio" value="snapchat" v-model="platform" :checked="platform === 'snapchat'" :disabled="true"/>
                           <span><i class="fab fa-snapchat-ghost"></i>&nbsp;Snapchat</span>
                        </label> -->
                     </div>
                  </div>
                  <div class="form-url" v-show="type === 'story'">
                     <div class="control">
                        <label>Story sequence</label>
                        <FileInput v-on:custom="handleStoryUpload" v-bind:id="'storyfile'" v-bind:label="'Upload story sequence'" v-bind:accept="'image/jpeg,image/png,image/gif,video/mp4,video/quicktime'" v-bind:isList="true" v-bind:icon="'fas fa-plus'" v-bind:multiple="false"></FileInput>
                        <p>If there are multiple images or videos for the story, we recommend creating one tracker per image or video.</p>
                     </div>
                     <div class="control">
                        <label>{{platform === 'instagram' ? 'Instagram' : 'Snapchat'}} username</label>
                        <input v-model="username" type="text" placeholder="Username"/>
                        <p>Influencer username</p>
                     </div>
                     <div class="control">
                        <label>Reach</label>
                        <vue-numeric v-model="reach"></vue-numeric>
                        <p>Accounts reached with this story.</p>
                     </div>
                     <div class="control">
                        <label>Impressions</label>
                        <vue-numeric v-model="impressions"></vue-numeric>
                        <p>Number of impressions.</p>
                     </div>
                     <div class="control">
                        <label>Interactions</label>
                        <vue-numeric v-model="interactions"></vue-numeric>
                        <p>Actions taken from this story.</p>
                     </div>
                     <div class="control">
                        <label>Back</label>
                        <vue-numeric v-model="back"></vue-numeric>
                        <p>Number of taps users made to see the previous photo or video in this story.</p>
                     </div>
                     <div class="control">
                        <label>Forward</label>
                        <vue-numeric v-model="forward"></vue-numeric>
                        <p>Number of taps users made to see the next photo or video in this story.</p>
                     </div>
                     <div class="control">
                        <label>Next story</label>
                        <vue-numeric v-model="next_story"></vue-numeric>
                        <p>Number of taps users made to see the next account's story.</p>
                     </div>
                     <div class="control">
                        <label>Exited</label>
                        <vue-numeric v-model="exited"></vue-numeric>
                        <p>Number of times a user swiped away from this story.</p>
                     </div>
                  </div>
               </div>

               <div class="modal-form__actions">
                  <button class="btn btn-success" :disabled="disableAction()">Create</button>
                  <button class="btn btn-danger" @click="dismiss" type="button">Cancel</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</template>
<script>
import {mapGetters} from 'vuex';
import FileInput from '../FileInput';
import VueTagsInput from '@johmun/vue-tags-input';

export default {
   components: {
      FileInput,
      VueTagsInput
   },
   props: {
      show: {
         default: false,
         type: Boolean
      },
      campaigns: {
         type: Array,
         default: () => {
            return [];
         }
      }
   },
   data() {
      return {
            user_id: null,
            campaign_id: null,
            platform: "instagram",
            name: null,
            type: "url",
            username: null,
            story: null,
            url: '',
            urls: [],
            reach: null,
            impressions: null,
            interactions: null,
            back: null,
            forward: null,
            next_story: null,
            exited: null,
         };
   },
   created() {
      document.addEventListener("keydown", e => {
         if (e.key == "Escape" && this.show) {
            this.dismiss();
         }
      });
   },
   methods: {
      init(){
         this.campaign_id = null;
         this.user_id = null;
         this.platform = "instagram";
         this.name = null;
         this.type = "url";
         this.username = null;
         this.story = null;
         this.url = '';
         this.urls = [];
         this.reach = null;
         this.impressions = null;
         this.interactions = null;
         this.back = null;
         this.forward = null;
         this.next_story = null;
         this.exited = null;
      },
      dismiss() {
         this.$emit("dismiss");
      },
      handleStoryUpload(files){
         if(typeof files === "undefined" && files.length > 0)
            return;

         this.story = files;
      },
      disableAction(){
         if(!this.campaign_id || !this.name)
            return true;

         let urlPattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
            '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
            '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
            '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
            '(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
            '(\\#[-a-z\\d_]*)?$','i');

         if(this.type === 'url' && urlPattern.test(this.url))
            return false;
         
         if(this.type === 'story' && this.story.length > 0 && this.username)
            return false;

         if(this.type === 'post' && this.urls.length > 0)
            return false;

         return true;
      },
      saveTracker(){
         let _data = {
            name: this.name,
            type: this.type,
            campaign_id: this.campaign_id,
            platform: this.type !== 'url' ? this.platform : null
         };

         let _urls = "";

         // Set POST data
         if(this.type === 'url'){
            _data.url = this.url;
         }
         
         // Set URL data
         if(this.type === 'post' && this.urls.length > 0){
            this.urls.map((item, key) => {
               _urls += item.text + ";";
            });

            _data.url = _urls;
         }
         
         // Set STORY data
         if(this.type === 'story'){
            // STORY data
            _data.username = this.username;
            _data.story = this.story;
            _data.reach = this.reach;
            _data.impressions = this.impressions;
            _data.interactions = this.interactions;
            _data.back = this.back;
            _data.forward = this.forward;
            _data.next_story = this.next_story;
            _data.exited = this.exited;
         }

         this.$emit("create", {
            data: _data
         })
         this.init();
      }
   }
};
</script>
<style scoped>
.modal-content {
   min-width: 80%;
}
</style>