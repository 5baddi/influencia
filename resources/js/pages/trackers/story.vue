<template>
    <div class="p-1">
        <div class="card">
            <header>
               <h2>{{ $route.params.uuid ? 'Enter story insights' : 'Add new story' }}</h2>
            </header>
            <div class="card__content">
                <form enctype="multipart/form-data" ref="trackerForm" v-on:submit.prevent="saveTracker">
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
                        <div class="form-url">
                            <div class="form-control">
                                <p class="modal-form__heading">Which platform was used to post the {{ type }}?</p>
                                <label for="instagram" class="instagram-radio">
                                <input type="radio" value="instagram" v-model="platform" :checked="platform === 'instagram'"/>
                                <span><i class="fab fa-instagram"></i>&nbsp;Instagram</span>
                                </label>
                                <label for="youtube" class="youtube-radio">
                                <input :disabled="true" type="radio" value="youtube" v-model="platform" :checked="platform === 'youtube'"/>
                                <span><i class="fab fa-youtube"></i>&nbsp;YouTube</span>
                                </label>
                                <!-- <label for="snapchat" class="snapchat-radio">
                                <input type="radio" value="snapchat" v-model="platform" :checked="platform === 'snapchat'" :disabled="true"/>
                                <span><i class="fab fa-snapchat-ghost"></i>&nbsp;Snapchat</span>
                                </label> -->
                            </div>
                        </div>
                        <div class="form-url">
                            <div class="control" v-if="!$route.params.uuid">
                                <label>Story sequence</label>
                                <FileInput v-on:custom="handleStoryUpload" v-bind:id="'storyfile'" v-bind:label="'Upload story sequence'" v-bind:accept="'image/jpeg,image/png,image/gif,video/mp4,video/quicktime'" v-bind:isList="true" v-bind:icon="'fas fa-plus'" v-bind:multiple="false"></FileInput>
                                <p>If there are multiple images or videos for the story, we recommend creating one story per image or video.</p>
                            </div>
                            <div class="control">
                                <label>Story insights proofs</label>
                                <FileInput v-on:custom="handleStoryUpload" v-bind:id="'storyfile'" v-bind:label="'Upload story insights screenshots'" v-bind:accept="'image/jpeg,image/png,image/gif'" v-bind:isList="true" v-bind:icon="'fas fa-plus'" v-bind:multiple="true"></FileInput>
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
                            <div class="control">
                                <label>Published at</label>
                                <datetime v-model="published_at" type="datetime" title="Story publiction datetime" :use12-hour="false"></datetime>
                                <p>Story publiction datetime.</p>
                            </div>
                        </div>
                    </div>

                    <div class="modal-form__actions">
                        <button class="btn btn-success" :disabled="disableAction()">Create</button>
                        <router-link class="btn btn-danger" :to="{name: 'stories'}">Cancel</router-link>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<style scoped>
    header{
        border-bottom: 1px solid rgba(204, 204, 204, 0.43);
    }
</style>
<script>
import {mapGetters} from 'vuex';
import FileInput from '../../components/FileInput';
import VueTagsInput from '@johmun/vue-tags-input';

export default {
   components: {
      FileInput,
      VueTagsInput
   },
   notifications: {
        createTrackerErrors: {
            type: "error"
        },
        createTrackerSuccess: {
            type: "success"
        },
        showError: {
            type: "error",
            title: "Error",
            message: "Something going wrong! Please try again.."
        },
        showSuccess: {
            type: "success",
        }
    },
    computed: {
        ...mapGetters(["AuthenticatedUser", "campaigns"])
    },
   methods: {
        loadCampaigns(){
            this.$store.dispatch("fetchCampaigns").catch(e => {});
        },
        handleStoryUpload(files){
            if(typeof files[0] === "undefined")
                return;

            this.story = files[0];
        },
        handleProofsUpload(files){
            if(typeof files === "undefined" || files.length < 1)
                return;

            this.proofs = files;
        },
        disableAction(){
            if(!this.campaign_id || this.campaign_id === -1 || !this.name || !this.username)
                return true;
            
            if(this.type === 'story' && this.story && this.username)
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
            
            // Set STORY data
            if(this.type === 'story'){
                // STORY data
                _data.username = this.username;
                _data.story = this.story;
                _data.proofs = this.proofs;
                _data.reach = this.reach;
                _data.impressions = this.impressions;
                _data.interactions = this.interactions;
                _data.back = this.back;
                _data.forward = this.forward;
                _data.next_story = this.next_story;
                _data.exited = this.exited;
                _data.published_at = this.published_at;
            }

            // Create new tracker
            this.create(_data);
        },
        create(data) {
            let formData = new FormData();

            // Set base tracker info
            formData.append("campaign_id", data.campaign_id);
            formData.append("name", data.name);
            formData.append("type", data.type);
            formData.append("platform", data.platform);
            formData.append("username", data.username);

            // Append story files
            formData.append("story", data.story);
            Array.from(data.proofs).forEach(file => {
                formData.append("proofs[]", file);
            });

            // Dispatch the creation action
            this.$store.dispatch("addNewStory", formData)
                .then(response => {
                    this.createTrackerSuccess({
                        message: `Story ${response.content.name} created successfuly!`
                    });
                    this.$router.push({ name: 'stories' });
                })
                .catch(error => {
                    let errors = Object.values(error.response.data.errors);
                    if(typeof errors === "object" && errors.length > 0){
                        errors.forEach(element => {
                            this.showError({
                                message: element
                            });
                        });
                    }else{
                        this.showError({
                            message: error.response.data.message
                        });
                    }
                });
        }
   },
   mounted(){
        // Load campaigns
        if(typeof this.campaigns === "undefined" || this.campaigns === null || Object.values(this.campaigns).length === 0)
            this.loadCampaigns();
    },
   data() {
        return {
            campaign_id: null,
            platform: "instagram",
            name: null,
            type: "story",
            username: null,
            story: null,
            proofs: [],
            reach: 0,
            impressions: 0,
            interactions: 0,
            back: 0,
            forward: 0,
            next_story: 0,
            exited: 0,
            published_at: (new Date()).toISOString(),
        };
   },
};
</script>