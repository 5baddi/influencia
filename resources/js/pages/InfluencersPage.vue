<template>
<div class="influencers">
    <div class="hero" v-if="!influencer">
        <div class="hero__intro">
            <h1>Influencers</h1>
            <ul class="breadcrumbs">
                <li>
                    <router-link :to="{name: 'dashboard'}">Dashboard</router-link>
                </li>
                <li>
                    <a href="#">Influencers</a>
                </li>
            </ul>
        </div>
        <div class="hero__actions">
            <button class="btn btn-success" @click="addInfluencer()">Add new influencer</button>
        </div>
    </div>
    <div class="p-1" v-if="!influencer">
        <header class="cards">
            <div class="card">
                <div class="number">{{ influencers.length | formatedNbr }}</div>
                <p class="description">NUMBER OF INFLUENCERS</p>
            </div>
        </header>
        <div class="datatable-scroll">
            <DataTable ref="influencersDT" :columns="columns" :nativeData="influencers" fetchMethod="fetchInfluencers" cssClasses="table-card">
                <th slot="header">Actions</th>
                <td slot="body-row" slot-scope="row">
                    <router-link :to="{name : 'influencers', params: {uuid: row.data.original.uuid}}" class="icon-link" title="Influencer details">
                        <i class="fas fa-eye"></i>
                    </router-link>
                    <button v-if="($can('delete', 'influencer') || (AuthenticatedUser && AuthenticatedUser.is_superadmin))" :disabled="row.data.original.trackers_count > 0" class="btn icon-link" :title="row.data.original.trackers_count > 0 ? 'already associated with a tracker' : 'Delete influencer'" @click="deleteInfluencer(row.data.original)">
                        <i class="far fa-trash-alt"></i>
                    </button>
                </td>
            </DataTable>
        </div>
    </div>
    <InfluencerProfile v-if="influencer" :influencer="influencer" />
    <CreateInfluencerModal ref="influencerFormModal" @create="create" />
    <ConfirmationModal ref="confirmDeleteInfluencerModal" v-on:custom="deleteInfluencerAction" />
</div>
</template>

<script>
import InfluencerProfile from "../components/InfluencerProfile";
import CreateInfluencerModal from "../components/modals/CreateInfluencerModal";
import {
    mapGetters
} from "vuex";

export default {
    components: {
        InfluencerProfile,
        CreateInfluencerModal
    },
    notifications: {
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
        ...mapGetters(["AuthenticatedUser", "influencers", "influencer"])
    },
    watch: {
        "$route.params.uuid": function(value){
            // Load influencer or unset influencer state
            if(typeof value !== "undefined")
                this.fetchInfluencer();
            else
                this.$store.commit("setInfluencer", {influencer: null});
        }
    },
    methods: {
        loadInfluencers() {
            // Fetch influencers
            if(typeof this.influencers === "undefined" || this.influencers === null || Object.values(this.influencers).length === 0)
                this.$store.dispatch("fetchInfluencers");
        },
        fetchInfluencer() {
            // Load influencer by UUID
            if (typeof this.$route.params.uuid !== 'undefined')
                this.$store.dispatch("fetchInfluencer", this.$route.params.uuid);
            else
                this.$store.commit("setInfluencer", {
                    influencer: null
                });
        },
        addInfluencer(){
            this.$refs.influencerFormModal.open();
        },
        deleteInfluencer(influencer){
            this.$refs.confirmDeleteInfluencerModal.open("Are sure to delete this influencer?", influencer);
        },
        deleteInfluencerAction(influencer){
            if (typeof influencer.uuid === "undefined")
                this.showError();

            this.$store.dispatch("deleteInfluencer", influencer.uuid)
                .then(response => {
                    this.$refs.influencersDT.reloadData();
                    this.showSuccess({
                        message: "Successfully deleted influencer @" + influencer.username
                    });
                }).catch(error => {
                    this.showError({
                        message: error.message
                    });
                });
        },
        create(influencer) {
            this.$store.dispatch("addInfluencer", influencer)
                .then(response => {
                    this.$refs.influencerFormModal.close();
                    this.showSuccess({
                        message: response.message
                    });
                }).catch(error => {
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
        // Load influencer
        if(typeof this.$route.params.uuid !== "undefined"){
            this.fetchInfluencer();
        }else{
            // Unset tracker state
            this.$store.commit("setInfluencer", {influencer: null});

            // Load influencers
            this.loadInfluencers();
        }
    },
    data() {
        return {
            columns: [{
                    field: "pic_url",
                    isAvatar: true,
                    isImage: true,
                    sortable: false
                },
                {
                    name: "Full name",
                    field: "name",
                    callback: function (row) {
                        let $html = '';

                        if(row.platform === "instagram")
                            $html = '<a href="https://instagram.com/' + row.username + '" target="_blank">' + (row.name ? row.name : '@' + row.username) + '</a>';
                        else if(row.platform === "youtube")
                            $html = '<a href="https://www.youtube.com/channel/' + row.account_id + '" target="_blank">' + row.name + '</a>';
                    
                        return $html;
                    }
                },
                {
                    name: "Followers",
                    field: "followers",
                    isNbr: true
                },
                {
                    name: "Media",
                    field: "medias",
                    isNbr: true
                },
                {
                    name: "Platform",
                    field: "platform",
                    callback: function (row) {
                        let link = "";
                        let icon = "";

                        if (row.platform === "instagram") {
                            link = "https://instagram.com/";
                            icon = "<i class=\"fab fa-instagram instagram-icon\"></i>";
                        }else if(row.platform === "youtube"){
                            link = "https://youtube.com/";
                            icon = "<i class=\"fab fa-youtube youtube-icon\"></i>";
                        }

                        return '<a href="' + link + '" target="_blank" title="' + row.platform + '" class="icon-link">' + icon + '</a>';
                    }
                },
                {
                    name: "Engagement rate",
                    field: "engagement_rate",
                    isPercentage: true
                },
                {
                    name: "Analyzed",
                    field: "posts_count",
                    callback: function (row) {
                        return ((row.posts_count / row.medias) * 100).toFixed(2) + '%';
                    }
                },
                {
                    name: "Last update",
                    field: "updated_at",
                    isTimeAgo: true
                }
            ]
        };
    }
};
</script>
