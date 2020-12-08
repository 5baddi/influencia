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
            <button class="btn btn-success" @click="showAddTrackerModal = !showAddTrackerModal">Add new tracker</button>
        </div>
    </div>
    <div class="p-1" v-if="!tracker">
        <header class="cards">
            <div class="card">
                <div class="number">{{ (campaigns.all && campaigns.all.length) ? campaigns.all.length : 0 }}</div>
                <p class="description">NUMBER OF CAMPAIGNS</p>
            </div>
            <div class="card">
                <div class="number">{{ (trackers && trackers.length) ? trackers.length : 0 }}</div>
                <p class="description">NUMBER OF TRACKERS</p>
            </div>
            <div class="card">
                <div class="number">{{ campaigns && campaigns.impressions ? campaigns.impressions.toLocaleString().replace(/,/g, ' ') : '---' }}</div>
                <p class="description">TOTAL ESTIMATED IMPRESSIONS</p>
            </div>
            <div class="card">
                <div class="number">{{ campaigns && campaigns.communities ? campaigns.communities.toLocaleString().replace(/,/g, ' ') : '---' }}</div>
                <p class="description">TOTAL SIZE OF ACTIVATED COMMUNITIES</p>
            </div>
        </header>
        <div class="datatable-scroll" v-if="$can('list', 'tracker') || (AuthenticatedUser && AuthenticatedUser.is_superadmin)">
            <DataTable ref="trackersDT" :columns="columns" fetchMethod="fetchTrackers" :exportable="true" :excelLink="'/api/v1/export/excel/' + activeBrand.uuid + '/trackers'" :endPoint="'/api/v1/stream/' + activeBrand.uuid + '/trackers'" cssClasses="table-card">
                <th slot="header">Actions</th>
                <td slot="body-row" slot-scope="row">
                    <router-link v-if="$can('analytics', 'tracker') || (AuthenticatedUser && AuthenticatedUser.is_superadmin)" v-show="row.data.original.queued === 'finished'" :to="{name : 'trackers', params: {uuid: row.data.original.uuid}}" class="icon-link" title="Statistics">
                        <i class="far fa-chart-bar"></i>
                    </router-link>
                    <button v-if="(($can('show', 'tracker') || (AuthenticatedUser && AuthenticatedUser.is_superadmin))) && row.data.original.type == 'url'" class="btn icon-link" title="Copy shortlink" @click="copyShortlink(row.data.original)">
                        <i class="fas fa-link"></i>
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
                        <i class="far fa-trash-alt"></i>
                    </button>
                </td>
            </DataTable>
        </div>
    </div>
    <CreateTrackerModal :show="showAddTrackerModal" @create="create" @dismiss="dismissAddTrackerModal" />
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
    watch: {
        $route: "initData"
    },
    beforeRouteEnter(to, from, next) {
        next(vm => vm.initData());
    },
    beforeRouteUpdate(to, from, next) {
        next(vm => vm.fatchTracker())
    },
    data() {
        return {
            showAddTrackerModal: false,
            columns: [{
                    name: "Name",
                    field: "name"
                },
                {
                    name: "Status",
                    field: "status",
                    callback: function (row) {
                        return '<span class="status status-' + (row.status ? 'success' : 'danger') + '" title="' + (row.status ? 'Enabled' : 'Disabled') + '">' + (row.queued.charAt(0).toUpperCase() + row.queued.slice(1)) + '</span>';
                    }
                },
                {
                    name: "Influencers",
                    field: "influencers",
                    callback: function (row) {
                        if (row.influencers.length === 0)
                            return '-';

                        let html = '';
                        row.influencers.map(function (item, index) {
                            // html += '<li>' + item.name.toUpperCase() + '</li>';
                            html += '<span class="badge badge-success">' + (item.name ? item.name.toUpperCase() : ('@' + item.username)) + '</span>';;
                        });

                        return html;
                    }
                },
                {
                    name: "Meduim",
                    field: "platform",
                    callback: function (row) {
                        switch (row.platform) {
                            case "youtube":
                                return '<i class="fab fa-2 fa-youtube" title="' + row.platform + '"></i>';
                                break;
                            case "instagram":
                                return '<i class="fab fa-2 fa-instagram" title="' + row.platform + '"></i>';
                                break;
                            default:
                                return '<i class="fas fa-2 fa-globe" title="' + row.type + '"></i>';
                                break;
                        }
                    }
                },
                {
                    name: "Last update",
                    field: "updated_at",
                    isData: true,
                    format: "DD/MM/YYYY"
                }
            ]
        };
    },
    created() {
        this.initData();
    },
    computed: {
        ...mapGetters(["AuthenticatedUser", "activeBrand", "campaigns", "trackers", "tracker"])
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
    methods: {
        initData() {
            // Fetch brand compaigns
            this.$store.dispatch("fetchCampaigns");
            // Fetch brand trackers
            this.$store.dispatch("fetchTrackers");
            // Fetch tracker analytics
            this.fetchTracker();
        },
        fetchTracker() {
            // Load user by UUID
            if (typeof this.$route.params.uuid !== 'undefined')
                this.$store.dispatch("fetchTrackerAnalytics", this.$route.params.uuid);
            else
                this.$store.commit("setTracker", {
                    tracker: null
                });
        },
        dismissAddTrackerModal() {
            this.showAddTrackerModal = false;
        },
        copyShortlink(tracker) {
            if (typeof tracker.shortlink.fulllink === "undefined")
                this.showError();

            let input = document.createElement("textarea");
            document.body.appendChild(input);
            input.value = tracker.shortlink.fulllink;
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
                    this.$refs.trackersDT.reloadData();
                    this.showSuccess({
                        message: "Successfully deleted tracker '" + tracker.name + "'"
                    });
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
            formData.append("user_id", data.user_id);
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
                    this.createTrackerErrors({
                        title: "Error",
                        message: `${error.message}`
                    });
                    // error.errors.map((v, i) => {
                    //    console.log(v);
                    // });
                });
        }
    }
};
</script>
