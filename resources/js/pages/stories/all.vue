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
        addStory(){

        }
    }
}
</script>