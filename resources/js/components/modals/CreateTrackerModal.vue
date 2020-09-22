<template>
   <div class="modal" :class="{'show-modal' : show}">
      <div class="modal-content">
         <header>
            <h4 class="heading">Add new Tracker</h4>
         </header>
         <div class="modal-form">
            <form ref="trackerForm" v-on:submit.prevent="saveTracker">
               <p class="modal-form__heading">What would you like to track?</p>
               <div class="radio-group">
                  <div class="radio-group__item" :class="{active: type === 'url'}">
                     <label for="url">
                        <input type="radio" id="url" value="url" v-model="type" />
                        <span>Visits to a URL</span>
                        <p>Track the number of visits and the location of the users that clicked on a link. There is absolutely no code to add to the destination URL to allow tracking, so you can track any URL, even if it's not your site.</p>
                     </label>
                  </div>
                  <div class="radio-group__item" :class="{active: type === 'post'}">
                     <label for="post">
                        <input type="radio" id="post" value="post" v-model="type" />
                        <span>Interactions for a post on a blog or social media</span>
                        <p>Track the number of interactions for any public post on blogs or social media.</p>
                     </label>
                  </div>
                  <div class="radio-group__item" :class="{active: type === 'story'}">
                     <label for="story">
                        <input type="radio" id="story" value="story" v-model="type" />
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
                        <select :options="campaigns" :disabled="!campaigns"></select>
                        <p>Assign tracker to a exists campaign</p>
                     </div>
                  </div>
                  <div class="form-url" v-show="type === 'url' || type === 'post'">
                     <div class="control">
                        <label>{{ type === 'url' ? 'Destination URL' : 'Post URL' }}</label>
                        <input v-model="url" type="text" placeholder="https://" />
                        <p v-show="type === 'url'">We will generate a shortened URL which will redirect to the destination URL and allow us to track the number and location of visits.</p>
                        <p v-show="type === 'post'">You can specify multiple post URLs on blogs or social media, one URL per line. Several trackers will then be created.</p>
                     </div>
                  </div>
                  <div class="form-url" v-show="type === 'story'">
                     <div class="control">
                        <label>Story medias</label>
                        <FileInput v-bind:id="'upload-story'" v-bind:label="'Add new Trackers'" v-bind:accept="'image/*,video/mp4,video/x-m4v,video/*'" v-bind:icon="'fas fa-plus'" v-bind:multiple="false"></FileInput>
                        <p>If there are multiple images or videos for the story, we recommend creating one tracker per image or video.</p>
                     </div>
                     <div class="form-control">
                        <p class="modal-form__heading">Which platform was used to post the story?</p>
                        <label for="instagram" class="instagram-radio">
                           <input type="radio" value="instagram" v-model="platform" :checked="platform === 'instagram'"/>
                           <span><i class="fab fa-instagram"></i>&nbsp;Instagram</span>
                        </label>
                        <label for="snapchat" class="snapchat-radio">
                           <input type="radio" value="snapchat" v-model="platform" :checked="platform === 'snapchat'" :disabled="true"/>
                           <span><i class="fab fa-snapchat-ghost"></i>&nbsp;Snapchat</span>
                        </label>
                     </div>
                     <div class="control">
                        <label>{{platform === 'instagram' ? 'Instagram' : 'Snapchat'}} username</label>
                        <input v-model="username" type="text" placeholder="Username"/>
                        <p>Influencer username</p>
                     </div>
                     <div class="control">
                        <label>Number of sequences</label>
                        <input v-model="n_squences" type="text" placeholder="https://" />
                        <p>If you leave this field empty, we'll display the number of files uploaded above as the number of sequences.</p>
                     </div>
                     <div class="control">
                        <label>Total number of sequence impressions</label>
                        <input v-model="n_squences_impressions" type="text" />
                        <p>Sum of impressions for all sequences. This metric will be called Sequence impressions on campaign dashboards.</p>
                     </div>
                     <div class="control">
                        <label>Number of impressions of the first sequence</label>
                        <input v-model="n_impressions_first_sequence" type="text" />
                        <p>Sum of impressions for all sequences. This metric will be called Sequence impressions on campaign dashboards.</p>
                     </div>
                     <div class="control">
                        <label>Reach of the first sequence</label>
                        <input v-model="reach_first_sequence" type="text" />
                        <p>This metric is needed to calculate the Completion rate. This metric will be called Reach (last sequence) on campaign dashboards.</p>
                     </div>
                     <div class="control">
                        <label>Sticker taps (mentions)</label>
                        <input v-model="sticker_taps_mentions" type="text" />
                        <p>This metric will be included in Engagements</p>
                     </div>
                     <div class="control">
                        <label>Sticker taps (hashtags)</label>
                        <input v-model="sticker_taps_hashtags" type="text" />
                        <p>This metric will be included in Engagements</p>
                     </div>
                     <div class="control">
                        <label>Link clicks</label>
                        <input v-model="link_clicks" type="text" />
                        <p>Do not complete this field if clicks come from a visit tracker (p.dm). This metric will be included in Engagements</p>
                     </div>
                     <div class="control">
                        <label>Number of replies</label>
                        <input v-model="n_replies" type="text" />
                     </div>
                     <div class="control">
                        <label>Number of taps forward</label>
                        <input v-model="n_taps_forward" type="text" />
                     </div>
                     <div class="control">
                        <label>Number of taps back</label>
                        <input v-model="n_taps_backward" type="text" />
                     </div>
                     <div class="control">
                        <label>Date story posted:</label>
                        <div class="group">
                           <input v-model="date_story" type="text" placeholder="dd/mm/yyyy" />
                           <span>at</span>
                           <input v-model="time_story" type="text" placeholder="17" />
                           <span>hrs</span>
                        </div>
                     </div>
                  </div>
               </div>

               <div class="modal-form__actions">
                  <button class="btn btn-success">Create</button>
                  <button class="btn btn-danger" @click="dismiss">Cancel</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</template>
<script>
import {mapGetters} from 'vuex';
import FileInput from '../FileInput';
export default {
   components: {
      FileInput
   },
   props: {
      show: {
         default: false,
         type: Boolean
      }
   },
   data() {
      return {
         platform: "instagram",
         name: null,
         type: "url",
         username: null,
         url: null,
         n_squences: null,
         n_squences_impressions: null,
         n_impressions_first_sequence: null,
         reach_first_sequence: null,
         sticker_taps_mentions: null,
         sticker_taps_hashtags: null,
         link_clicks: null,
         n_replies: null,
         n_taps_forward: null,
         n_taps_backward: null,
         time_story: null,
         date_story: null,
      };
   },
   created() {
      document.addEventListener("keydown", e => {
         if (e.key == "Escape" && this.show) {
            this.dismiss();
         }
      });
   },
   computed: {
      ...mapGetters(["campaigns"])
   },
   methods: {
      dismiss() {
         this.$emit("dismiss");
      },
      saveTracker(){
         let _data = {
            name: this.name,
            type: this.type,
            username: this.username,
         };

         // Set URL/POST data
         if(this.type === 'url' || this.type === 'post'){
            _data.url = this.url;
         }else{
            // STORY data
            _data.platform = this.platform;
            _data.n_squences = this.n_squences;
            _data.n_squences_impressions = this.n_squences_impressions;
            _data.n_impressions_first_sequence = this.n_impressions_first_sequence;
            _data.reach_first_sequence = this.reach_first_sequence;
            _data.sticker_taps_mentions = this.sticker_taps_mentions;
            _data.sticker_taps_hashtags = this.sticker_taps_hashtags;
            _data.link_clicks = this.link_clicks;
            _data.n_replies = this.n_replies;
            _data.n_taps_forward = this.n_taps_forward;
            _data.n_taps_backward = this.n_taps_backward;
            _data.time_story = this.time_story;
            _data.date_story = this.date_story;
         }

         this.$emit("create", {
            data: _data
         });
      }
   }
};
</script>
<style scoped>
.modal-content {
   min-width: 80%;
}
</style>