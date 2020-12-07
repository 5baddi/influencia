<template>
   <div class="modal" :class="{'show-modal': show}"> 
      <div class="modal-content">
         <header>
            <h4 class="heading">Add new influencer</h4>
         </header>
         <div class="modal-form">
            <div class="forms">
               <div class="form-url">
                  <div class="control">
                     <label>Username or ID</label>
                     <input v-model="username" type="text" placeholder="Username"/>
                     <p>You can find the Username or ID on the official influencer page, it is different from platform to another one.</p>
                  </div>
               </div>
               <div class="form-url">
                     <div class="form-control">
                        <p class="modal-form__heading">Which platform was used by the influencer?</p>
                        <label for="instagram" class="instagram-radio">
                           <input type="radio" value="instagram" v-model="platform" :checked="platform === 'instagram'"/>
                           <span><i class="fab fa-instagram"></i>&nbsp;Instagram</span>
                        </label>
                        <label for="youtube" class="youtube-radio">
                           <input type="radio" value="youtube" v-model="platform" :checked="platform === 'youtube'"/>
                           <span><i class="fab fa-youtube"></i>&nbsp;YouTube</span>
                        </label>
                        <label for="snapchat" class="snapchat-radio">
                           <input type="radio" value="snapchat" v-model="platform" :checked="platform === 'snapchat'" :disabled="true"/>
                           <span><i class="fab fa-snapchat-ghost"></i>&nbsp;Snapchat</span>
                        </label>

                     </div>
                  </div>
            </div>
            <div class="modal-form__actions">
               <button class="btn btn-success" :disabled="!isValidated()" @click.prevent="submit()">Add</button>
               <button class="btn btn-danger" @click.prevent="close()">Cancel</button>
            </div>
         </div>
      </div>
   </div>
</template>
<script>
export default {
   data() {
      return {
          show: false,
          platform: 'instagram',
          username: null
      };
   },
   created() {
      // Hide action on keyboard key
      document.addEventListener("keydown", e => {
         if(e.key == "Escape" && this.show){
               this.dismiss();
         }
      });
   },
   methods: {
      open(){
          this.show = true;
      },
      close(){
          this.show = false;

          this.platform = 'instagram';
          this.username = null;
      },
      submit() {
         this.$emit("create", {
            username: this.username,
            platform: this.platform
         });
      },
      isValidated(){
         return ['instagram', 'youtube'].includes(this.platform) && typeof this.username !== "undefined" && this.username !== null && this.username.length >= 1;
      }
   }
};
</script>