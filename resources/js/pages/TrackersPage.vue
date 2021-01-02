<template>
<div class="trackers">
    <div class="hero">
        <div class="hero__intro">
            <h1>{{ (tracker && tracker.name) ? tracker.name.toUpperCase() : 'Trackers' }}</h1>
            <ul class="breadcrumbs">
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li>
                    <a href="#">Trackers</a>
                </li>
            </ul>
        </div>
        <div class="hero__actions" v-if="!tracker">
            <button class="btn btn-success" :disabled="!campaigns || typeof campaigns.length === 'undefined' || campaigns.length === 0" @click="showAddTrackerModal = !showAddTrackerModal">Add new tracker</button>
        </div>
    </div>
    <div class="p-1" v-if="!tracker">
        <header class="cards">
            <div class="card">
                <div class="number">{{ trackers.length | formatedNbr }}</div>
                <p class="description">NUMBER OF TRACKERS</p>
            </div>                                                                                                                                                                                                                                                                   
        </header>
        <section class="actions-card">
            <h4>Trackers list for</h4>
            <select v-model="selectedCampaign" @change="loadByCampaign()">
                <option :value="null" selected>all campaigns</option>
                <option v-for="camp in campaigns" :value="camp" :key="camp.id">{{ camp.name }}</option>
            </select>
        </section>
        <div class="datatable-scroll" v-if="$can('list', 'tracker') || (AuthenticatedUser && AuthenticatedUser.is_superadmin)">
            <DataTable ref="trackersDT" :columns="columns" :searchable="true" :searchCols="['name', 'username']" :nativeData="trackers" fetchMethod="fetchTrackers" cssClasses="table-card">
                <th slot="header">Actions</th>
                <td slot="body-row" slot-scope="row">
                    <router-link v-if="$can('analytics', 'tracker') || (AuthenticatedUser && AuthenticatedUser.is_superadmin)" v-show="row.data.original.queued === 'finished'" :to="{name : 'trackers', params: {uuid: row.data.original.uuid}}" class="icon-link" title="Statistics">
                        <i class="far fa-chart-bar datatable-icon"></i>
                    </router-link>
                    <button v-if="(($can('show', 'tracker') || (AuthenticatedUser && AuthenticatedUser.is_superadmin))) && row.data.original.type == 'url'" class="btn icon-link" title="Copy shortlink" @click="copyShortlink(row.data.original)">
                        <i class="fas fa-link datatable-icon"></i>
                    </button>
                    <button v-if="($can('change-status', 'tracker') || (AuthenticatedUser && AuthenticatedUser.is_superadmin))" class="btn icon-link" :title="(row.data.original.status ? 'Stop' : 'Start') + ' tracker'" @click="enableTracker(row.data.original)">
                        <svg v-show="row.data.original.status" data-v-4b997e69="" class="svg-inline--fa fa-stop-circle fa-w-16" aria-hidden="true" focusable="false" data-prefix="far" data-icon="stop-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                            <path fill="currentColor" d="M504 256C504 119 393 8 256 8S8 119 8 256s111 248 248 248 248-111 248-248zm-448 0c0-110.5 89.5-200 200-200s200 89.5 200 200-89.5 200-200 200S56 366.5 56 256zm296-80v160c0 8.8-7.2 16-16 16H176c-8.8 0-16-7.2-16-16V176c0-8.8 7.2-16 16-16h160c8.8 0 16 7.2 16 16z"></path>
                        </svg>
                        <svg v-show="!row.data.original.status" data-v-4b997e69="" class="svg-inline--fa fa-play-circle fa-w-16" aria-hidden="true" focusable="false" data-prefix="far" data-icon="play-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                            <path fill="currentColor" d="M371.7 238l-176-107c-15.8-8.8-35.7 2.5-35.7 21v208c0 18.4 19.8 29.8 35.7 21l176-101c16.4-9.1 16.4-32.8 0-42zM504 256C504 119 393 8 256 8S8 119 8 256s111 248 248 248 248-111 248-248zm-448 0c0-110.5 89.5-200 200-200s200 89.5 200 200-89.5 200-200 200S56 366.5 56 256z"></path>
                        </svg>
                    </button>
                    <button v-if="($can('delete', 'tracker') || (AuthenticatedUser && AuthenticatedUser.is_superadmin))" class="btn icon-link" title="Delete tracker" @click="deleteTracker(row.data.original)">
                        <i class="far fa-trash-alt datatable-icon"></i>
                    </button>
                </td>
            </DataTable>
        </div>
    </div>
    <CreateTrackerModal :show="showAddTrackerModal" :campaigns="campaigns" @create="create" @dismiss="dismissAddTrackerModal" />
    <ConfirmationModal ref="confirmModal" v-on:custom="deleteAction" />
    <TrackerAnalytics v-if="tracker" :tracker="tracker" />
</div>
</template>

<script>
import {
    mapGetters
} from "vuex";
import CreateTrackerModal from "../components/modals/CreateTrackerModal";
import TrackerAnalytics from "../components/TrackerAnalytics";
export default {
    components: {
        CreateTrackerModal,
        TrackerAnalytics
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
        ...mapGetters(["AuthenticatedUser", "campaigns", "trackers", "tracker"])
    },
    watch: {
        "$route.params.uuid": function(value){
            // Load tracker analytics or unset tracker state
            if(typeof value !== "undefined")
                this.fetchTracker();
            else
                this.$store.commit("setTracker", {tracker: null});
        },
        "$route.params.campaign": function(value){
            // Load trackers by campaign
            if(typeof value !== "undefined"){
                // Load campaigns
                this.loadCampaigns(value);
                // Load trackers by campaign
                this.loadByCampaign();
            }
        }
    },
    methods: {
        loadCampaigns(selectedCampaignUUID){
            if(typeof this.campaigns === "undefined" || this.campaigns === null || Object.values(this.campaigns).length === 0){
                this.$store.dispatch("fetchCampaigns")
                    .then(response => {
                        if(response.success && selectedCampaignUUID !== null && typeof selectedCampaignUUID !== "undefined"){
                            this.selectedCampaign = response.content.find(item => item.uuid == selectedCampaignUUID);
                        }
                    });
            }else{
                if(selectedCampaignUUID !== null && typeof selectedCampaignUUID !== "undefined"){
                    this.selectedCampaign = this.campaigns.find(item => item.uuid == selectedCampaignUUID);
                }
            }
        },
        loadTrackers() {
            // Fetch compaigns
            this.loadCampaigns();
            // Fetch trackers
            if(typeof this.trackers === "undefined" || this.trackers === null || Object.values(this.trackers).length === 0)
                this.$store.dispatch("fetchTrackers");
        },
        fetchTracker() {
            // Load tracker analytics by UUID
            if (typeof this.$route.params.uuid !== 'undefined')
                this.$store.dispatch("fetchTrackerAnalytics", this.$route.params.uuid);
            else
                this.$store.commit("setTracker", {
                    tracker: null
                });
        },
        loadByCampaign(){
            if(this.selectedCampaign === null || typeof this.selectedCampaign === "undefined"){
                this.$refs.trackersDT.reloadData();
                
                if(this.$route.params.campaign !== null && typeof this.$route.params.campaign !== "undefined"){
                    this.$router.replace({ name: 'trackers', force: true });   
                }
            }
            if(this.selectedCampaign !== null && typeof this.selectedCampaign !== "undefined" && typeof this.selectedCampaign.uuid !== "undefined")
                this.$store.dispatch("fetchTrackersByCampaign", this.selectedCampaign.uuid);
        },
        dismissAddTrackerModal() {
            this.showAddTrackerModal = false;
        },
        copyShortlink(tracker) {
            if (typeof tracker.fulllink === "undefined")
                this.showError();

            let input = document.createElement("textarea");
            document.body.appendChild(input);
            input.value = tracker.fulllink;
            input.select();
            document.execCommand("copy");
            document.body.removeChild(input);
            this.showSuccess({
                message: "Link copied."
            });
        },
        enableTracker(tracker) {
            this.$store.dispatch("changeTrackerStatus", tracker.uuid)
                .then(response => {
                    this.$refs.trackersDT.reloadData();
                    this.showSuccess({
                        message: response.message
                    });
                }).catch(error => {
                    this.showError({
                        message: error.message
                    });
                });
        },
        deleteTracker(tracker) {
            this.$refs.confirmModal.open("Are sure to delete this tracker?", tracker);
        },
        deleteAction(tracker) {
            if (typeof tracker.uuid === "undefined")
                this.showError();

            this.$store.dispatch("deleteTracker", tracker.uuid)
                .then(response => {
                    this.showSuccess({
                        message: "Successfully deleted tracker '" + tracker.name + "'"
                    });

                    if(typeof this.$route.params.campaign !== "undefined"){
                        // Load campaigns
                        this.loadCampaigns(this.$route.params.campaign);
                        // Load trackers by campaign
                        this.loadByCampaign();
                    }else{
                        this.$refs.trackersDT.reloadData();
                    }
                }).catch(error => {
                    this.showError({
                        message: error.message
                    });
                });
        },
        create(payload) {
            let data = payload.data;
            let formData = new FormData();

            // Set base tracker info
            formData.append("user_id", this.AuthenticatedUser.id);
            formData.append("campaign_id", data.campaign_id);
            formData.append("name", data.name);
            formData.append("type", data.type);
            if (data.type !== 'url')
                formData.append("platform", data.platform);

            // Create story tracker
            if (data.type === "story") {
                // Append form data
                formData.append("username", data.username);
                Array.from(data.story).forEach(file => {
                    formData.append("story[]", file);
                });
            } else {
                formData.append("url", data.url);
            }

            // Dispatch the creation action
            this.$store.dispatch("addNewTracker", formData)
                .then(response => {
                    this.dismissAddTrackerModal();
                    this.$refs.trackersDT.reloadData();
                    this.createTrackerSuccess({
                        message: `Tracker ${response.content.name} created successfuly!`
                    });
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
        // Load tracker analytics
        if(typeof this.$route.params.uuid !== "undefined"){
            this.fetchTracker();
        }else{
            // Unset tracker state
            this.$store.commit("setTracker", {tracker: null});

            if(typeof this.$route.params.campaign !== "undefined"){
                // Load campaigns
                this.loadCampaigns(this.$route.params.campaign);
                // Load trackers by campaign
                this.loadByCampaign();
            }else{
                this.selectedCampaign = null;

                // Load trackers
                this.loadTrackers();
            }
        }
    },
    data() {
        return {
            showAddTrackerModal: false,
            selectedCampaign: null,
            columns: [{
                    name: "Name",
                    field: "name"
                },
                {
                    name: "Status",
                    field: "status",
                    sortable: false,
                    callback: function (row) {
                        return '<span class="status status-' + (row.status ? 'success' : 'danger') + '" title="' + (row.status ? 'Enabled' : 'Disabled') + '">' + (row.queued.charAt(0).toUpperCase() + row.queued.slice(1)) + '</span>';
                    }
                },
                {
                    name: "Campaign",
                    field: "campaign",
                    isLink: true,
                    callback: function (row) {
                        return {
                            content: (row.campaign.name.charAt(0).toUpperCase() + row.campaign.name.slice(1)),
                            title: "Show trackers",
                            route: {name : 'campaign_trackers', params: {campaign: row.campaign.uuid}, force: true} 
                        };
                    }
                },
                {
                    name: "Influencers",
                    field: "influencers",
                    class: "avatars-list",
                    sortable: false,
                    callback: function (row) {
                        if (row.influencers.length === 0)
                            return '-';

                        let html = '';
                        row.influencers.map(function (item, index) {
                            html += '<a href="/influencers/' + item.uuid + '" class="avatars-list" title="View ' + (item.name ? item.name : item.username) + ' profile"><img src="' + item.pic_url + '"/>';
                        });

                        return html;
                    }
                },
                {
                    name: "Meduim",
                    field: "platform",
                    sortable: false,
                    callback: function (row) {
                        if(row.platform === null)
                            return '<i class="fas fa-2 fa-globe web-icon datatable-icon" title="' + row.type + '"></i>';

                        switch (row.platform) {
                            case "youtube":
                                return '<i class="fab fa-2 fa-youtube youtube-icon datatable-icon" title="' + row.platform + '"></i>';
                            break;
                            case "instagram":
                                return '<i class="fab fa-2 fa-instagram instagram-icon datatable-icon" title="' + row.platform + '"></i>';
                            break;
                        }
                    }
                },
                {
                    name: "Activated communities",
                    field: "communities",
                    isNbr: true
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
