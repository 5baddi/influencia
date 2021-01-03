(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[3],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/TrackerAnalytics.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/TrackerAnalytics.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var number_abbreviate__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! number-abbreviate */ "./node_modules/number-abbreviate/index.js");
/* harmony import */ var number_abbreviate__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(number_abbreviate__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var chart_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! chart.js */ "./node_modules/chart.js/dist/Chart.js");
/* harmony import */ var chart_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(chart_js__WEBPACK_IMPORTED_MODULE_1__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


/* harmony default export */ __webpack_exports__["default"] = ({
  props: {
    tracker: {
      type: Object,
      "default": function _default() {
        return {};
      }
    }
  },
  methods: {
    nbr: function nbr() {
      return new number_abbreviate__WEBPACK_IMPORTED_MODULE_0___default.a();
    },
    createDoughtnutChart: function createDoughtnutChart(id, data) {
      var chartEl = document.getElementById(id);
      var chart = new chart_js__WEBPACK_IMPORTED_MODULE_1___default.a(chartEl, {
        type: 'doughnut',
        data: data
      });
    }
  },
  mounted: function mounted() {
    if (typeof this.tracker.type !== "undefined" && this.tracker.type === "post") {
      // Comments sentiments
      if (typeof this.tracker.sentiments_positive === 'number' && typeof this.tracker.sentiments_neutral === 'number' && typeof this.tracker.sentiments_negative === 'number') {
        this.createDoughtnutChart('sentiments-chart', {
          datasets: [{
            data: [this.tracker.sentiments_positive.toFixed(2), this.tracker.sentiments_neutral.toFixed(2), this.tracker.sentiments_negative.toFixed(2)],
            backgroundColor: ["#AFD75C", "#999999", "#ED435A" //#d93176
            ]
          }],
          labels: ['Positive ' + this.tracker.sentiments_positive.toFixed(2), 'Neutral ' + this.tracker.sentiments_neutral.toFixed(2), 'Negative ' + this.tracker.sentiments_negative.toFixed(2)]
        });
      } // Communities


      if (this.tracker.communities && this.tracker.communities > 0) {
        this.createDoughtnutChart('communities-chart', {
          datasets: [{
            data: [this.tracker.communities],
            backgroundColor: ['#d93176']
          }],
          labels: ['Instagram']
        });
      } // Impressions


      if (this.tracker.impressions && this.tracker.impressions > 0) {
        this.createDoughtnutChart('impressions-chart', {
          datasets: [{
            data: [this.tracker.impressions],
            backgroundColor: ['#d93176']
          }],
          labels: ['Instagram']
        });
      } // Videos views


      if (this.tracker.video_views && this.tracker.video_views > 0) {
        this.createDoughtnutChart('views-chart', {
          datasets: [{
            data: [this.tracker.video_views],
            backgroundColor: ['#d93176']
          }],
          labels: ['Instagram']
        });
      } // Engagements


      if (this.tracker.engagements && this.tracker.engagements > 0) {
        this.createDoughtnutChart('engagements-chart', {
          datasets: [{
            data: [this.tracker.engagements],
            backgroundColor: ['#d93176']
          }],
          labels: ['Instagram']
        });
      } // Posts


      if (this.tracker.posts_count && this.tracker.posts_count > 0) {
        var postsAndStoriesLabel = 'Instagram: ' + (this.tracker.posts_count ? this.tracker.posts_count : 0) + ' including ' + (this.tracker.stories_count ? this.tracker.stories_count : 0) + ' stories';
        this.createDoughtnutChart('posts-chart', {
          datasets: [{
            data: [this.tracker.posts_count],
            backgroundColor: ['#d93176']
          }],
          labels: [postsAndStoriesLabel]
        });
      }
    }
  },
  data: function data() {
    return {
      influencersColumns: [{
        field: 'pic_url',
        isAvatar: true,
        sortable: false,
        isImage: true,
        callback: function callback(row) {
          return row.pic_url;
        }
      }, {
        name: 'Influencer',
        field: 'uuid',
        callback: function callback(row) {
          return row.name ? row.name : row.username;
        }
      }, {
        name: 'Number of posts',
        field: 'medias',
        isNbr: true
      }, {
        name: 'Size of activated communities',
        field: 'estimated_communities',
        isNbr: true
      }, {
        name: 'Estimated impressions',
        field: 'estimated_impressions',
        isNbr: true
      }, {
        name: 'Earned Media Value',
        field: 'earned_media_value',
        currency: '€'
      }],
      instaMediaColumns: [{
        field: 'influencer_pic',
        isAvatar: true,
        isImage: true,
        sortable: false,
        callback: function callback(row) {
          return row.influencer.pic_url;
        }
      }, {
        name: 'Influencer',
        field: 'influencer',
        callback: function callback(row) {
          return row.influencer.name ? row.influencer.name : row.influencer.username;
        }
      }, {
        name: 'Post',
        field: 'link',
        callback: function callback(row) {
          if (!row.link || !row.caption) return '<p>---</p>';
          return '<a href="' + row.link + '" target="_blank">' + row.caption.substr(1, 100) + '...</a>';
        }
      }, {
        name: 'Media type',
        field: 'type',
        capitalize: true
      }, {
        name: 'Size of activated communities',
        field: 'activated_communities',
        isNbr: true
      }, {
        name: 'Estimated impressions',
        field: 'estimated_impressions',
        isNbr: true
      }, {
        name: 'Engagements',
        field: 'engagements',
        isNbr: true
      }, {
        name: 'Organic impressions (declarative)',
        field: 'organic_impressions',
        isNbr: true
      }, {
        name: 'Engagements rate (reach)',
        field: 'engagement_rate',
        callback: function callback(row) {
          return row.influencer.engagement_rate && row.influencer.engagement_rate > 0 ? (row.influencer.engagement_rate * 100).toFixed(2) : '-';
        }
      }, {
        name: 'Likes',
        field: 'likes',
        isNbr: true
      }, {
        name: 'Views',
        field: 'video_views',
        isNbr: true
      }, {
        name: 'Comments',
        field: 'comments',
        isNbr: true
      }, {
        name: 'Impressions (first sequence)'
      }, {
        name: 'Story sequences'
      }, {
        name: 'Sequence impressions'
      }, {
        name: 'Posted at',
        field: 'published_at'
      }, {
        name: 'Earned Media Value',
        field: 'earned_media_value',
        currency: '€'
      }],
      attrActive: null,
      sentimentData: {
        labels: ['Positive', 'Neutral', 'Negative'],
        backgroundColor: ["#AFD75C", "#999999", "#ED435A"]
      }
    };
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/modals/CreateTrackerModal.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/modals/CreateTrackerModal.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
/* harmony import */ var _FileInput__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../FileInput */ "./resources/js/components/FileInput.vue");
/* harmony import */ var _johmun_vue_tags_input__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @johmun/vue-tags-input */ "./node_modules/@johmun/vue-tags-input/dist/vue-tags-input.js");
/* harmony import */ var _johmun_vue_tags_input__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_johmun_vue_tags_input__WEBPACK_IMPORTED_MODULE_2__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//



/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    FileInput: _FileInput__WEBPACK_IMPORTED_MODULE_1__["default"],
    VueTagsInput: _johmun_vue_tags_input__WEBPACK_IMPORTED_MODULE_2___default.a
  },
  props: {
    show: {
      "default": false,
      type: Boolean
    },
    campaigns: {
      type: Array,
      "default": function _default() {
        return [];
      }
    }
  },
  data: function data() {
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
      date_story: null
    };
  },
  created: function created() {
    var _this = this;

    document.addEventListener("keydown", function (e) {
      if (e.key == "Escape" && _this.show) {
        _this.dismiss();
      }
    });
  },
  methods: {
    init: function init() {
      this.campaign_id = null;
      this.user_id = null;
      this.platform = "instagram";
      this.name = null;
      this.type = "url";
      this.username = null;
      this.story = null;
      this.url = '';
      this.urls = [];
      this.n_squences = null;
      this.n_squences_impressions = null;
      this.n_impressions_first_sequence = null;
      this.reach_first_sequence = null;
      this.sticker_taps_mentions = null;
      this.sticker_taps_hashtags = null;
      this.link_clicks = null;
      this.n_replies = null;
      this.n_taps_forward = null;
      this.n_taps_backward = null;
      this.time_story = null;
      this.date_story = null;
    },
    dismiss: function dismiss() {
      this.$emit("dismiss");
    },
    handleStoryUpload: function handleStoryUpload(files) {
      if (typeof files === "undefined" && files.length > 0) return;
      this.story = files;
    },
    disableAction: function disableAction() {
      if (!this.campaign_id || !this.name) return true;
      var urlPattern = new RegExp('^(https?:\\/\\/)?' + // protocol
      '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|' + // domain name
      '((\\d{1,3}\\.){3}\\d{1,3}))' + // OR ip (v4) address
      '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' + // port and path
      '(\\?[;&a-z\\d%_.~+=-]*)?' + // query string
      '(\\#[-a-z\\d_]*)?$', 'i');
      if (this.type === 'url' && urlPattern.test(this.url)) return false;
      if (this.type === 'story' && this.story.length > 0 && this.username) return false;
      if (this.type === 'post' && this.urls.length > 0) return false;
      return true;
    },
    saveTracker: function saveTracker() {
      var _data = {
        name: this.name,
        type: this.type,
        campaign_id: this.campaign_id,
        platform: this.type !== 'url' ? this.platform : null
      };
      var _urls = ""; // Set POST data

      if (this.type === 'url') {
        _data.url = this.url;
      } // Set URL data


      if (this.type === 'post' && this.urls.length > 0) {
        this.urls.map(function (item, key) {
          _urls += item.text + ";";
        });
        _data.url = _urls;
      } // Set STORY data


      if (this.type === 'story') {
        // STORY data
        _data.username = this.username;
        _data.story = this.story;
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
      this.init();
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/TrackersPage.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/TrackersPage.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
/* harmony import */ var _components_modals_CreateTrackerModal__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../components/modals/CreateTrackerModal */ "./resources/js/components/modals/CreateTrackerModal.vue");
/* harmony import */ var _components_TrackerAnalytics__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../components/TrackerAnalytics */ "./resources/js/components/TrackerAnalytics.vue");
function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//



/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    CreateTrackerModal: _components_modals_CreateTrackerModal__WEBPACK_IMPORTED_MODULE_1__["default"],
    TrackerAnalytics: _components_TrackerAnalytics__WEBPACK_IMPORTED_MODULE_2__["default"]
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
      type: "success"
    }
  },
  computed: _objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapGetters"])(["AuthenticatedUser", "campaigns", "trackers", "tracker"])),
  watch: {
    "$route.params.uuid": function $routeParamsUuid(value) {
      // Load tracker analytics or unset tracker state
      if (typeof value !== "undefined") this.fetchTracker();else this.$store.commit("setTracker", {
        tracker: null
      });
    },
    "$route.params.campaign": function $routeParamsCampaign(value) {
      // Load trackers by campaign
      if (typeof value !== "undefined") {
        // Load campaigns
        this.loadCampaigns(value); // Load trackers by campaign

        this.loadByCampaign();
      }
    }
  },
  methods: {
    loadCampaigns: function loadCampaigns(selectedCampaignUUID) {
      var _this = this;

      if (typeof this.campaigns === "undefined" || this.campaigns === null || Object.values(this.campaigns).length === 0) {
        this.$store.dispatch("fetchCampaigns").then(function (response) {
          if (response.success && selectedCampaignUUID !== null && typeof selectedCampaignUUID !== "undefined") {
            _this.selectedCampaign = response.content.find(function (item) {
              return item.uuid == selectedCampaignUUID;
            });
          }
        });
      } else {
        if (selectedCampaignUUID !== null && typeof selectedCampaignUUID !== "undefined") {
          this.selectedCampaign = this.campaigns.find(function (item) {
            return item.uuid == selectedCampaignUUID;
          });
        }
      }
    },
    loadTrackers: function loadTrackers() {
      // Fetch compaigns
      this.loadCampaigns(); // Fetch trackers

      if (typeof this.trackers === "undefined" || this.trackers === null || Object.values(this.trackers).length === 0) this.$store.dispatch("fetchTrackers");
    },
    fetchTracker: function fetchTracker() {
      // Load tracker analytics by UUID
      if (typeof this.$route.params.uuid !== 'undefined') this.$store.dispatch("fetchTrackerAnalytics", this.$route.params.uuid);else this.$store.commit("setTracker", {
        tracker: null
      });
    },
    loadByCampaign: function loadByCampaign() {
      if (this.selectedCampaign === null || typeof this.selectedCampaign === "undefined") {
        this.$refs.trackersDT.reloadData();

        if (this.$route.params.campaign !== null && typeof this.$route.params.campaign !== "undefined") {
          this.$router.replace({
            name: 'trackers',
            force: true
          });
        }
      }

      if (this.selectedCampaign !== null && typeof this.selectedCampaign !== "undefined" && typeof this.selectedCampaign.uuid !== "undefined") this.$store.dispatch("fetchTrackersByCampaign", this.selectedCampaign.uuid);
    },
    dismissAddTrackerModal: function dismissAddTrackerModal() {
      this.showAddTrackerModal = false;
    },
    copyShortlink: function copyShortlink(tracker) {
      if (typeof tracker.fulllink === "undefined") this.showError();
      var input = document.createElement("textarea");
      document.body.appendChild(input);
      input.value = tracker.fulllink;
      input.select();
      document.execCommand("copy");
      document.body.removeChild(input);
      this.showSuccess({
        message: "Link copied."
      });
    },
    enableTracker: function enableTracker(tracker) {
      var _this2 = this;

      this.$store.dispatch("changeTrackerStatus", tracker.uuid).then(function (response) {
        _this2.$refs.trackersDT.reloadData();

        _this2.showSuccess({
          message: response.message
        });
      })["catch"](function (error) {
        _this2.showError({
          message: error.message
        });
      });
    },
    deleteTracker: function deleteTracker(tracker) {
      this.$refs.confirmModal.open("Are sure to delete this tracker?", tracker);
    },
    deleteAction: function deleteAction(tracker) {
      var _this3 = this;

      if (typeof tracker.uuid === "undefined") this.showError();
      this.$store.dispatch("deleteTracker", tracker.uuid).then(function (response) {
        _this3.showSuccess({
          message: "Successfully deleted tracker '" + tracker.name + "'"
        });

        if (typeof _this3.$route.params.campaign !== "undefined") {
          // Load campaigns
          _this3.loadCampaigns(_this3.$route.params.campaign); // Load trackers by campaign


          _this3.loadByCampaign();
        } else {
          _this3.$refs.trackersDT.reloadData();
        }
      })["catch"](function (error) {
        _this3.showError({
          message: error.message
        });
      });
    },
    create: function create(payload) {
      var _this4 = this;

      var data = payload.data;
      var formData = new FormData(); // Set base tracker info

      formData.append("user_id", this.AuthenticatedUser.id);
      formData.append("campaign_id", data.campaign_id);
      formData.append("name", data.name);
      formData.append("type", data.type);
      if (data.type !== 'url') formData.append("platform", data.platform); // Create story tracker

      if (data.type === "story") {
        // Append form data
        formData.append("username", data.username);
        Array.from(data.story).forEach(function (file) {
          formData.append("story[]", file);
        });
      } else {
        formData.append("url", data.url);
      } // Dispatch the creation action


      this.$store.dispatch("addNewTracker", formData).then(function (response) {
        _this4.dismissAddTrackerModal();

        _this4.$refs.trackersDT.reloadData();

        _this4.createTrackerSuccess({
          message: "Tracker ".concat(response.content.name, " created successfuly!")
        });
      })["catch"](function (error) {
        var errors = Object.values(error.response.data.errors);

        if (_typeof(errors) === "object" && errors.length > 0) {
          errors.forEach(function (element) {
            _this4.showError({
              message: element
            });
          });
        } else {
          _this4.showError({
            message: error.response.data.message
          });
        }
      });
    }
  },
  mounted: function mounted() {
    // Load tracker analytics
    if (typeof this.$route.params.uuid !== "undefined") {
      this.fetchTracker();
    } else {
      // Unset tracker state
      this.$store.commit("setTracker", {
        tracker: null
      });

      if (typeof this.$route.params.campaign !== "undefined") {
        // Load campaigns
        this.loadCampaigns(this.$route.params.campaign); // Load trackers by campaign

        this.loadByCampaign();
      } else {
        this.selectedCampaign = null; // Load trackers

        this.loadTrackers();
      }
    }
  },
  data: function data() {
    return {
      showAddTrackerModal: false,
      selectedCampaign: null,
      columns: [{
        name: "Name",
        field: "name"
      }, {
        name: "Status",
        field: "status",
        sortable: false,
        callback: function callback(row) {
          return '<span class="status status-' + (row.status ? 'success' : 'danger') + '" title="' + (row.status ? 'Enabled' : 'Disabled') + '">' + (row.queued.charAt(0).toUpperCase() + row.queued.slice(1)) + '</span>';
        }
      }, {
        name: "Campaign",
        field: "campaign",
        isLink: true,
        callback: function callback(row) {
          return {
            content: row.campaign.name.charAt(0).toUpperCase() + row.campaign.name.slice(1),
            title: "Show trackers",
            route: {
              name: 'campaign_trackers',
              params: {
                campaign: row.campaign.uuid
              },
              force: true
            }
          };
        }
      }, {
        name: "Influencers",
        field: "influencers",
        "class": "avatars-list",
        sortable: false,
        callback: function callback(row) {
          if (row.influencers.length === 0) return '-';
          var html = '';
          row.influencers.map(function (item, index) {
            html += '<a href="/influencers/' + item.uuid + '" class="avatars-list" title="View ' + (item.name ? item.name : item.username) + ' profile"><img src="' + item.pic_url + '"/>';
          });
          return html;
        }
      }, {
        name: "Meduim",
        field: "platform",
        sortable: false,
        callback: function callback(row) {
          if (row.platform === null) return '<i class="fas fa-2 fa-globe web-icon datatable-icon" title="' + row.type + '"></i>';

          switch (row.platform) {
            case "youtube":
              return '<i class="fab fa-2 fa-youtube youtube-icon datatable-icon" title="' + row.platform + '"></i>';
              break;

            case "instagram":
              return '<i class="fab fa-2 fa-instagram instagram-icon datatable-icon" title="' + row.platform + '"></i>';
              break;
          }
        }
      }, {
        name: "Activated communities",
        field: "communities",
        isNbr: true
      }, {
        name: "Last update",
        field: "updated_at",
        isTimeAgo: true
      }]
    };
  }
});

/***/ }),

/***/ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/modals/CreateTrackerModal.vue?vue&type=style&index=0&id=079a9bc2&scoped=true&lang=css&":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/modals/CreateTrackerModal.vue?vue&type=style&index=0&id=079a9bc2&scoped=true&lang=css& ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "\n.modal-content[data-v-079a9bc2] {\r\n   min-width: 80%;\n}\r\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/modals/CreateTrackerModal.vue?vue&type=style&index=0&id=079a9bc2&scoped=true&lang=css&":
/*!***********************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/modals/CreateTrackerModal.vue?vue&type=style&index=0&id=079a9bc2&scoped=true&lang=css& ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../../node_modules/css-loader??ref--6-1!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--6-2!../../../../node_modules/vue-loader/lib??vue-loader-options!./CreateTrackerModal.vue?vue&type=style&index=0&id=079a9bc2&scoped=true&lang=css& */ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/modals/CreateTrackerModal.vue?vue&type=style&index=0&id=079a9bc2&scoped=true&lang=css&");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/TrackerAnalytics.vue?vue&type=template&id=adf462ce&":
/*!*******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/TrackerAnalytics.vue?vue&type=template&id=adf462ce& ***!
  \*******************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _vm.tracker
    ? _c("div", { staticClass: "campaign" }, [
        _c(
          "ul",
          {
            directives: [
              {
                name: "show",
                rawName: "v-show",
                value:
                  typeof _vm.tracker.influencers !== "undefined" &&
                  _vm.tracker.influencers.length > 0,
                expression:
                  "typeof tracker.influencers !== 'undefined' && tracker.influencers.length > 0"
              }
            ],
            staticClass: "influencers-avatars"
          },
          [
            _c("h4", [_vm._v("influencers")]),
            _vm._v(" "),
            _vm._l(_vm.tracker.influencers, function(influencer) {
              return _c(
                "li",
                { key: influencer.id },
                [
                  _c(
                    "router-link",
                    {
                      staticClass: "icon-link",
                      attrs: {
                        to: {
                          name: "influencers",
                          params: { uuid: influencer.uuid }
                        },
                        title: influencer.name
                          ? influencer.name
                          : influencer.username
                      }
                    },
                    [
                      _c("img", {
                        attrs: { src: influencer.pic_url, loading: "lazy" }
                      })
                    ]
                  )
                ],
                1
              )
            })
          ],
          2
        ),
        _vm._v(" "),
        _c("div", { staticClass: "cards statistics" }, [
          _vm.tracker.communities > 0
            ? _c("div", { staticClass: "card" }, [
                _c("div", { staticClass: "title" }, [
                  _c("i", { staticClass: "fas fa-users egg-blue" }),
                  _vm._v(" "),
                  _c("div", { staticClass: "numbers" }, [
                    _c("h4", [
                      _vm._v(
                        _vm._s(_vm._f("formatedNbr")(_vm.tracker.communities))
                      )
                    ]),
                    _vm._v(" "),
                    _c("span", [_vm._v("Total size of activated communities")])
                  ])
                ]),
                _vm._v(" "),
                _c("canvas", { attrs: { id: "communities-chart" } })
              ])
            : _vm._e(),
          _vm._v(" "),
          _vm.tracker.impressions > 0
            ? _c("div", { staticClass: "card" }, [
                _c("div", { staticClass: "title" }, [
                  _c("i", { staticClass: "fas fa-bullhorn purple" }),
                  _vm._v(" "),
                  _c("div", { staticClass: "numbers" }, [
                    _c("h4", [
                      _vm._v(
                        _vm._s(_vm._f("formatedNbr")(_vm.tracker.impressions))
                      )
                    ]),
                    _vm._v(" "),
                    _c("span", [_vm._v("Total estimated impressions")])
                  ])
                ]),
                _vm._v(" "),
                _c("canvas", { attrs: { id: "impressions-chart" } }),
                _vm._v(" "),
                _c("span", [
                  _vm._v(
                    "Organic impressions " +
                      _vm._s(
                        String(
                          _vm.nbr().abbreviate(_vm.tracker.organic_impressions)
                        ).toUpperCase()
                      ) +
                      " (" +
                      _vm._s(
                        _vm.tracker.impressions > 0
                          ? (
                              (_vm.tracker.organic_impressions /
                                _vm.tracker.impressions) *
                              100
                            ).toFixed(2)
                          : 0
                      ) +
                      "%)"
                  )
                ])
              ])
            : _vm._e(),
          _vm._v(" "),
          _vm.tracker.video_views > 0
            ? _c("div", { staticClass: "card" }, [
                _c("div", { staticClass: "title" }, [
                  _c("i", { staticClass: "far fa-eye green" }),
                  _vm._v(" "),
                  _c("div", { staticClass: "numbers" }, [
                    _c("h4", [
                      _vm._v(
                        _vm._s(_vm._f("formatedNbr")(_vm.tracker.video_views))
                      )
                    ]),
                    _vm._v(" "),
                    _c("span", [_vm._v("Total videos views")])
                  ])
                ]),
                _vm._v(" "),
                _c("canvas", { attrs: { id: "views-chart" } }),
                _vm._v(" "),
                _c("span", [
                  _vm._v(
                    "Organic videos views " +
                      _vm._s(
                        String(
                          _vm.nbr().abbreviate(_vm.tracker.organic_views)
                        ).toUpperCase()
                      ) +
                      " (" +
                      _vm._s(
                        _vm.tracker.video_views > 0
                          ? (
                              (_vm.tracker.organic_views /
                                _vm.tracker.video_views) *
                              100
                            ).toFixed(2)
                          : 0
                      ) +
                      "%)"
                  )
                ])
              ])
            : _vm._e(),
          _vm._v(" "),
          _vm.tracker.engagements > 0
            ? _c("div", { staticClass: "card" }, [
                _c("div", { staticClass: "title" }, [
                  _c("i", { staticClass: "fas fa-thumbs-up blue" }),
                  _vm._v(" "),
                  _c("div", { staticClass: "numbers" }, [
                    _c("h4", [
                      _vm._v(
                        _vm._s(_vm._f("formatedNbr")(_vm.tracker.engagements))
                      )
                    ]),
                    _vm._v(" "),
                    _c("span", [_vm._v("Total engagements")])
                  ])
                ]),
                _vm._v(" "),
                _c("canvas", { attrs: { id: "engagements-chart" } }),
                _vm._v(" "),
                _c("span", [
                  _vm._v(
                    "Organic engagements " +
                      _vm._s(
                        String(
                          _vm.nbr().abbreviate(_vm.tracker.organic_engagements)
                        ).toUpperCase()
                      ) +
                      " (" +
                      _vm._s(
                        _vm.tracker.engagements > 0
                          ? (
                              (_vm.tracker.organic_engagements /
                                _vm.tracker.engagements) *
                              100
                            ).toFixed(2)
                          : 0
                      ) +
                      "%)"
                  )
                ])
              ])
            : _vm._e(),
          _vm._v(" "),
          _vm.tracker.posts_count > 0
            ? _c("div", { staticClass: "card" }, [
                _c("div", { staticClass: "title" }, [
                  _c("i", { staticClass: "fas fa-hashtag yellow" }),
                  _vm._v(" "),
                  _c("div", { staticClass: "numbers" }, [
                    _c("h4", [
                      _vm._v(
                        _vm._s(_vm._f("formatedNbr")(_vm.tracker.posts_count))
                      )
                    ]),
                    _vm._v(" "),
                    _c("span", [_vm._v("Total number of posts")])
                  ])
                ]),
                _vm._v(" "),
                _c("canvas", { attrs: { id: "posts-chart" } }),
                _vm._v(" "),
                _c("span", [
                  _vm._v(
                    "Organic posts " +
                      _vm._s(
                        String(
                          _vm.nbr().abbreviate(_vm.tracker.organic_posts)
                        ).toUpperCase()
                      ) +
                      " (" +
                      _vm._s(
                        _vm.tracker.posts_count > 0
                          ? (
                              (_vm.tracker.organic_posts /
                                _vm.tracker.posts_count) *
                              100
                            ).toFixed(2)
                          : 0
                      ) +
                      "%)"
                  )
                ])
              ])
            : _vm._e()
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "cards sentiments" }, [
          _vm.tracker.comments_count > 0
            ? _c("div", { staticClass: "card" }, [
                _c("h5", [_vm._v("Comments sentiment")]),
                _vm._v(" "),
                _c("canvas", { attrs: { id: "sentiments-chart" } }),
                _vm._v(" "),
                _c("span", [
                  _vm._v(
                    "Based on " +
                      _vm._s(
                        _vm._f("formatedNbr")(_vm.tracker.comments_count)
                      ) +
                      " comments"
                  )
                ])
              ])
            : _vm._e(),
          _vm._v(" "),
          _vm.tracker.top_emojis &&
          typeof _vm.tracker.top_emojis.top !== "undefined" &&
          Object.values(_vm.tracker.top_emojis.top).length > 0
            ? _c("div", { staticClass: "card emojis" }, [
                _c("h5", [
                  _vm._v(
                    "Top " +
                      _vm._s(
                        _vm.tracker.top_emojis.top &&
                          Object.values(_vm.tracker.top_emojis.top).length > 1
                          ? Object.values(_vm.tracker.top_emojis.top).length +
                              " "
                          : ""
                      ) +
                      "emojis"
                  )
                ]),
                _vm._v(" "),
                _c(
                  "ul",
                  _vm._l(_vm.tracker.top_emojis.top, function(emoji, index) {
                    return _c("li", { key: index }, [
                      _vm._v(
                        "\r\n                    " +
                          _vm._s(emoji) +
                          "\r\n                    "
                      ),
                      _c("span", [
                        _vm._v(
                          _vm._s(
                            (
                              (index /
                                (_vm.tracker.top_emojis.all
                                  ? _vm.tracker.top_emojis.all
                                  : 1)) *
                              100
                            ).toFixed(2)
                          ) + "%"
                        )
                      ])
                    ])
                  }),
                  0
                ),
                _vm._v(" "),
                _c("span", [
                  _vm._v(
                    "Based on " +
                      _vm._s(
                        _vm._f("formatedNbr")(_vm.tracker.top_emojis.all)
                      ) +
                      " emojis"
                  )
                ])
              ])
            : _vm._e()
        ]),
        _vm._v(" "),
        _vm.tracker.type === "post" && _vm.tracker.influencers
          ? _c(
              "div",
              { staticClass: "datatable-scroll" },
              [
                _c("h4", [_vm._v("Performance breakdown by Influencer")]),
                _vm._v(" "),
                _c("DataTable", {
                  ref: "byInfluencer",
                  attrs: {
                    columns: _vm.influencersColumns,
                    nativeData: _vm.tracker.influencers,
                    cssClasses: "table-card"
                  }
                })
              ],
              1
            )
          : _vm._e(),
        _vm._v(" "),
        _vm.tracker.platform === "instagram"
          ? _c(
              "div",
              { staticClass: "datatable-scroll" },
              [
                _c("h4", [
                  _vm._v("Performance breakdown by post on Instagram")
                ]),
                _vm._v(" "),
                _c("DataTable", {
                  ref: "byInstaPosts",
                  attrs: {
                    columns: _vm.instaMediaColumns,
                    nativeData: _vm.tracker.instagram_media,
                    cssClasses: "table-card"
                  }
                })
              ],
              1
            )
          : _vm._e(),
        _vm._v(" "),
        _vm.tracker && _vm.tracker.posts_count > 0
          ? _c("div", { staticClass: "posts-section" }, [
              _c("h4", [_vm._v("Posts")]),
              _vm._v(" "),
              _c("p", [
                _vm._v(
                  "There are " +
                    _vm._s(
                      _vm.tracker && _vm.tracker.posts_count
                        ? _vm.tracker.posts_count
                        : 0
                    ) +
                    " posts for this tracker."
                )
              ]),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "campaign-posts" },
                _vm._l(_vm.tracker.media, function(media) {
                  return _c(
                    "a",
                    {
                      key: media.uuid,
                      staticClass: "campaign-posts-card",
                      attrs: { href: media.link, target: "_blank" },
                      on: {
                        mouseover: function($event) {
                          _vm.attrActive = media.uuid
                        },
                        mouseleave: function($event) {
                          _vm.attrActive = null
                        }
                      }
                    },
                    [
                      _c("img", {
                        attrs: { src: media.thumbnail_url, loading: "lazy" }
                      }),
                      _vm._v(" "),
                      _c("div", { staticClass: "campaign-posts-card-icons" }, [
                        _vm.tracker.platform === "instagram"
                          ? _c("i", { staticClass: "fab fa-instagram" })
                          : _vm._e(),
                        _vm._v(" "),
                        media.type === "video" || media.type === "sidecar"
                          ? _c("i", {
                              class:
                                "fas fa-" +
                                (media.type === "sidecar" ? "images" : "video")
                            })
                          : _vm._e()
                      ]),
                      _vm._v(" "),
                      _c(
                        "div",
                        {
                          class:
                            "campaign-posts-card-attr " +
                            (_vm.attrActive === media.uuid ? " active" : "")
                        },
                        [
                          media.video_views
                            ? _c("span", [
                                _c("i", { staticClass: "fas fa-eye" }),
                                _vm._v(
                                  _vm._s(
                                    String(
                                      _vm.nbr().abbreviate(media.video_views)
                                    ).toUpperCase()
                                  )
                                )
                              ])
                            : _vm._e(),
                          _vm._v(" "),
                          media.likes
                            ? _c("span", [
                                _c("i", { staticClass: "fas fa-heart" }),
                                _vm._v(
                                  _vm._s(
                                    String(
                                      _vm.nbr().abbreviate(media.likes)
                                    ).toUpperCase()
                                  )
                                )
                              ])
                            : _vm._e(),
                          _vm._v(" "),
                          media.comments
                            ? _c("span", [
                                _c("i", { staticClass: "fas fa-comment" }),
                                _vm._v(
                                  _vm._s(
                                    String(
                                      _vm.nbr().abbreviate(media.comments)
                                    ).toUpperCase()
                                  )
                                )
                              ])
                            : _vm._e()
                        ]
                      )
                    ]
                  )
                }),
                0
              )
            ])
          : _vm._e()
      ])
    : _vm._e()
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/modals/CreateTrackerModal.vue?vue&type=template&id=079a9bc2&scoped=true&":
/*!****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/modals/CreateTrackerModal.vue?vue&type=template&id=079a9bc2&scoped=true& ***!
  \****************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "modal", class: { "show-modal": _vm.show } },
    [
      _c("div", { staticClass: "modal-content" }, [
        _vm._m(0),
        _vm._v(" "),
        _c("div", { staticClass: "modal-form" }, [
          _c(
            "form",
            {
              ref: "trackerForm",
              attrs: { enctype: "multipart/form-data" },
              on: {
                submit: function($event) {
                  $event.preventDefault()
                  return _vm.saveTracker($event)
                }
              }
            },
            [
              _c("p", { staticClass: "modal-form__heading" }, [
                _vm._v("What would you like to track?")
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "radio-group" }, [
                _c(
                  "div",
                  {
                    staticClass: "radio-group__item",
                    class: { active: _vm.type === "url" }
                  },
                  [
                    _c("label", { attrs: { for: "url" } }, [
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.type,
                            expression: "type"
                          }
                        ],
                        attrs: { type: "radio", id: "url", value: "url" },
                        domProps: { checked: _vm._q(_vm.type, "url") },
                        on: {
                          change: function($event) {
                            _vm.type = "url"
                          }
                        }
                      }),
                      _vm._v(" "),
                      _c("span", [_vm._v("Visits to a URL")]),
                      _vm._v(" "),
                      _c("p", [
                        _vm._v(
                          "Track the number of visits and the location of the users that clicked on a link. There is absolutely no code to add to the destination URL to allow tracking, so you can track any URL, even if it's not your site."
                        )
                      ])
                    ])
                  ]
                ),
                _vm._v(" "),
                _c(
                  "div",
                  {
                    staticClass: "radio-group__item",
                    class: { active: _vm.type === "post" }
                  },
                  [
                    _c("label", { attrs: { for: "post" } }, [
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.type,
                            expression: "type"
                          }
                        ],
                        attrs: { type: "radio", id: "post", value: "post" },
                        domProps: { checked: _vm._q(_vm.type, "post") },
                        on: {
                          change: function($event) {
                            _vm.type = "post"
                          }
                        }
                      }),
                      _vm._v(" "),
                      _c("span", [
                        _vm._v(
                          "Interactions for a post on a blog or social media"
                        )
                      ]),
                      _vm._v(" "),
                      _c("p", [
                        _vm._v(
                          "Track the number of interactions for any public post on blogs or social media."
                        )
                      ])
                    ])
                  ]
                ),
                _vm._v(" "),
                _c(
                  "div",
                  {
                    staticClass: "radio-group__item",
                    class: { active: _vm.type === "story" }
                  },
                  [
                    _c("label", { attrs: { for: "story" } }, [
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.type,
                            expression: "type"
                          }
                        ],
                        attrs: {
                          type: "radio",
                          id: "story",
                          value: "story",
                          disabled: true
                        },
                        domProps: { checked: _vm._q(_vm.type, "story") },
                        on: {
                          change: function($event) {
                            _vm.type = "story"
                          }
                        }
                      }),
                      _vm._v(" "),
                      _c("span", [
                        _vm._v(
                          "Interactions for an Instagram or Snapchat story"
                        )
                      ]),
                      _vm._v(" "),
                      _c("p", [
                        _vm._v(
                          "Specify the metrics for a story and its content in order to include it in the aggregated statistics."
                        )
                      ])
                    ])
                  ]
                )
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "forms" }, [
                _c("div", { staticClass: "form-url" }, [
                  _c("div", { staticClass: "control" }, [
                    _c("label", [_vm._v("Tracker name")]),
                    _vm._v(" "),
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.name,
                          expression: "name"
                        }
                      ],
                      attrs: { type: "text", placeholder: "Name" },
                      domProps: { value: _vm.name },
                      on: {
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.name = $event.target.value
                        }
                      }
                    }),
                    _vm._v(" "),
                    _c("p", [
                      _vm._v(
                        "The tracker name is private. It's used in the tracker listing. If no name has been given, one will be automatically generated according to what is being tracked."
                      )
                    ])
                  ])
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "form-url" }, [
                  _c("div", { staticClass: "control" }, [
                    _c("label", [_vm._v("Assign to campaign")]),
                    _vm._v(" "),
                    _c(
                      "select",
                      {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.campaign_id,
                            expression: "campaign_id"
                          }
                        ],
                        on: {
                          change: function($event) {
                            var $$selectedVal = Array.prototype.filter
                              .call($event.target.options, function(o) {
                                return o.selected
                              })
                              .map(function(o) {
                                var val = "_value" in o ? o._value : o.value
                                return val
                              })
                            _vm.campaign_id = $event.target.multiple
                              ? $$selectedVal
                              : $$selectedVal[0]
                          }
                        }
                      },
                      [
                        _c(
                          "option",
                          {
                            attrs: { selected: "" },
                            domProps: { value: null }
                          },
                          [_vm._v("Select a campaign")]
                        ),
                        _vm._v(" "),
                        _vm._l(_vm.campaigns, function(camp) {
                          return _c(
                            "option",
                            { key: camp.id, domProps: { value: camp.id } },
                            [_vm._v(_vm._s(camp.name))]
                          )
                        })
                      ],
                      2
                    ),
                    _vm._v(" "),
                    _c("p", [_vm._v("Assign tracker to a exists campaign")])
                  ])
                ]),
                _vm._v(" "),
                _c(
                  "div",
                  {
                    directives: [
                      {
                        name: "show",
                        rawName: "v-show",
                        value: _vm.type !== "story",
                        expression: "type !== 'story'"
                      }
                    ],
                    staticClass: "form-url"
                  },
                  [
                    _c(
                      "div",
                      { staticClass: "control" },
                      [
                        _c("label", [
                          _vm._v(
                            _vm._s(
                              _vm.type === "url"
                                ? "Destination URL"
                                : "Post URL"
                            )
                          )
                        ]),
                        _vm._v(" "),
                        _vm.type === "url"
                          ? _c("input", {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: _vm.url,
                                  expression: "url"
                                }
                              ],
                              attrs: { type: "text", placeholder: "https://" },
                              domProps: { value: _vm.url },
                              on: {
                                input: function($event) {
                                  if ($event.target.composing) {
                                    return
                                  }
                                  _vm.url = $event.target.value
                                }
                              }
                            })
                          : _vm._e(),
                        _vm._v(" "),
                        _vm.type === "post"
                          ? _c("vue-tags-input", {
                              attrs: {
                                placeholder: "Add post URL",
                                tags: _vm.urls
                              },
                              on: {
                                "tags-changed": function(newUrls) {
                                  return (_vm.urls = newUrls)
                                }
                              },
                              model: {
                                value: _vm.url,
                                callback: function($$v) {
                                  _vm.url = $$v
                                },
                                expression: "url"
                              }
                            })
                          : _vm._e(),
                        _vm._v(" "),
                        _c(
                          "p",
                          {
                            directives: [
                              {
                                name: "show",
                                rawName: "v-show",
                                value: _vm.type === "url",
                                expression: "type === 'url'"
                              }
                            ]
                          },
                          [
                            _vm._v(
                              "We will generate a shortened URL which will redirect to the destination URL and allow us to track the number and location of visits."
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "p",
                          {
                            directives: [
                              {
                                name: "show",
                                rawName: "v-show",
                                value: _vm.type === "post",
                                expression: "type === 'post'"
                              }
                            ]
                          },
                          [
                            _vm._v(
                              "You can specify multiple post URLs on blogs or social media, one URL per line. Several trackers will then be created."
                            )
                          ]
                        )
                      ],
                      1
                    )
                  ]
                ),
                _vm._v(" "),
                _c(
                  "div",
                  {
                    directives: [
                      {
                        name: "show",
                        rawName: "v-show",
                        value: _vm.type !== "url",
                        expression: "type !== 'url'"
                      }
                    ],
                    staticClass: "form-url"
                  },
                  [
                    _c("div", { staticClass: "form-control" }, [
                      _c("p", { staticClass: "modal-form__heading" }, [
                        _vm._v(
                          "Which platform was used to post the " +
                            _vm._s(_vm.type) +
                            "?"
                        )
                      ]),
                      _vm._v(" "),
                      _c(
                        "label",
                        {
                          staticClass: "instagram-radio",
                          attrs: { for: "instagram" }
                        },
                        [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.platform,
                                expression: "platform"
                              }
                            ],
                            attrs: { type: "radio", value: "instagram" },
                            domProps: {
                              checked: _vm.platform === "instagram",
                              checked: _vm._q(_vm.platform, "instagram")
                            },
                            on: {
                              change: function($event) {
                                _vm.platform = "instagram"
                              }
                            }
                          }),
                          _vm._v(" "),
                          _vm._m(1)
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "label",
                        {
                          staticClass: "youtube-radio",
                          attrs: { for: "youtube" }
                        },
                        [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.platform,
                                expression: "platform"
                              }
                            ],
                            attrs: { type: "radio", value: "youtube" },
                            domProps: {
                              checked: _vm.platform === "youtube",
                              checked: _vm._q(_vm.platform, "youtube")
                            },
                            on: {
                              change: function($event) {
                                _vm.platform = "youtube"
                              }
                            }
                          }),
                          _vm._v(" "),
                          _vm._m(2)
                        ]
                      )
                    ])
                  ]
                ),
                _vm._v(" "),
                _c(
                  "div",
                  {
                    directives: [
                      {
                        name: "show",
                        rawName: "v-show",
                        value: _vm.type === "story",
                        expression: "type === 'story'"
                      }
                    ],
                    staticClass: "form-url"
                  },
                  [
                    _c(
                      "div",
                      { staticClass: "control" },
                      [
                        _c("label", [_vm._v("Story sequences")]),
                        _vm._v(" "),
                        _c("FileInput", {
                          attrs: {
                            id: "storyfile",
                            label: "Add new Trackers",
                            accept:
                              "image/jpeg,image/png,image/gif,video/mp4,video/quicktime",
                            isList: true,
                            icon: "fas fa-plus",
                            multiple: true
                          },
                          on: { custom: _vm.handleStoryUpload }
                        }),
                        _vm._v(" "),
                        _c("p", [
                          _vm._v(
                            "If there are multiple images or videos for the story, we recommend creating one tracker per image or video."
                          )
                        ])
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c("div", { staticClass: "control" }, [
                      _c("label", [
                        _vm._v(
                          _vm._s(
                            _vm.platform === "instagram"
                              ? "Instagram"
                              : "Snapchat"
                          ) + " username"
                        )
                      ]),
                      _vm._v(" "),
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.username,
                            expression: "username"
                          }
                        ],
                        attrs: { type: "text", placeholder: "Username" },
                        domProps: { value: _vm.username },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.username = $event.target.value
                          }
                        }
                      }),
                      _vm._v(" "),
                      _c("p", [_vm._v("Influencer username")])
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "control" }, [
                      _c("label", [_vm._v("Number of sequences")]),
                      _vm._v(" "),
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.n_squences,
                            expression: "n_squences"
                          }
                        ],
                        attrs: { type: "text", placeholder: "https://" },
                        domProps: { value: _vm.n_squences },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.n_squences = $event.target.value
                          }
                        }
                      }),
                      _vm._v(" "),
                      _c("p", [
                        _vm._v(
                          "If you leave this field empty, we'll display the number of files uploaded above as the number of sequences."
                        )
                      ])
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "control" }, [
                      _c("label", [
                        _vm._v("Total number of sequence impressions")
                      ]),
                      _vm._v(" "),
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.n_squences_impressions,
                            expression: "n_squences_impressions"
                          }
                        ],
                        attrs: { type: "text" },
                        domProps: { value: _vm.n_squences_impressions },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.n_squences_impressions = $event.target.value
                          }
                        }
                      }),
                      _vm._v(" "),
                      _c("p", [
                        _vm._v(
                          "Sum of impressions for all sequences. This metric will be called Sequence impressions on campaign dashboards."
                        )
                      ])
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "control" }, [
                      _c("label", [
                        _vm._v("Number of impressions of the first sequence")
                      ]),
                      _vm._v(" "),
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.n_impressions_first_sequence,
                            expression: "n_impressions_first_sequence"
                          }
                        ],
                        attrs: { type: "text" },
                        domProps: { value: _vm.n_impressions_first_sequence },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.n_impressions_first_sequence =
                              $event.target.value
                          }
                        }
                      }),
                      _vm._v(" "),
                      _c("p", [
                        _vm._v(
                          "Sum of impressions for all sequences. This metric will be called Sequence impressions on campaign dashboards."
                        )
                      ])
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "control" }, [
                      _c("label", [_vm._v("Reach of the first sequence")]),
                      _vm._v(" "),
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.reach_first_sequence,
                            expression: "reach_first_sequence"
                          }
                        ],
                        attrs: { type: "text" },
                        domProps: { value: _vm.reach_first_sequence },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.reach_first_sequence = $event.target.value
                          }
                        }
                      }),
                      _vm._v(" "),
                      _c("p", [
                        _vm._v(
                          "This metric is needed to calculate the Completion rate. This metric will be called Reach (last sequence) on campaign dashboards."
                        )
                      ])
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "control" }, [
                      _c("label", [_vm._v("Sticker taps (mentions)")]),
                      _vm._v(" "),
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.sticker_taps_mentions,
                            expression: "sticker_taps_mentions"
                          }
                        ],
                        attrs: { type: "text" },
                        domProps: { value: _vm.sticker_taps_mentions },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.sticker_taps_mentions = $event.target.value
                          }
                        }
                      }),
                      _vm._v(" "),
                      _c("p", [
                        _vm._v("This metric will be included in Engagements")
                      ])
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "control" }, [
                      _c("label", [_vm._v("Sticker taps (hashtags)")]),
                      _vm._v(" "),
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.sticker_taps_hashtags,
                            expression: "sticker_taps_hashtags"
                          }
                        ],
                        attrs: { type: "text" },
                        domProps: { value: _vm.sticker_taps_hashtags },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.sticker_taps_hashtags = $event.target.value
                          }
                        }
                      }),
                      _vm._v(" "),
                      _c("p", [
                        _vm._v("This metric will be included in Engagements")
                      ])
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "control" }, [
                      _c("label", [_vm._v("Link clicks")]),
                      _vm._v(" "),
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.link_clicks,
                            expression: "link_clicks"
                          }
                        ],
                        attrs: { type: "text" },
                        domProps: { value: _vm.link_clicks },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.link_clicks = $event.target.value
                          }
                        }
                      }),
                      _vm._v(" "),
                      _c("p", [
                        _vm._v(
                          "Do not complete this field if clicks come from a visit tracker (p.dm). This metric will be included in Engagements"
                        )
                      ])
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "control" }, [
                      _c("label", [_vm._v("Number of replies")]),
                      _vm._v(" "),
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.n_replies,
                            expression: "n_replies"
                          }
                        ],
                        attrs: { type: "text" },
                        domProps: { value: _vm.n_replies },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.n_replies = $event.target.value
                          }
                        }
                      })
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "control" }, [
                      _c("label", [_vm._v("Number of taps forward")]),
                      _vm._v(" "),
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.n_taps_forward,
                            expression: "n_taps_forward"
                          }
                        ],
                        attrs: { type: "text" },
                        domProps: { value: _vm.n_taps_forward },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.n_taps_forward = $event.target.value
                          }
                        }
                      })
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "control" }, [
                      _c("label", [_vm._v("Number of taps back")]),
                      _vm._v(" "),
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.n_taps_backward,
                            expression: "n_taps_backward"
                          }
                        ],
                        attrs: { type: "text" },
                        domProps: { value: _vm.n_taps_backward },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.n_taps_backward = $event.target.value
                          }
                        }
                      })
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "control" }, [
                      _c("label", [_vm._v("Date story posted:")]),
                      _vm._v(" "),
                      _c("div", { staticClass: "group" }, [
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: _vm.date_story,
                              expression: "date_story"
                            }
                          ],
                          attrs: { type: "text", placeholder: "dd/mm/yyyy" },
                          domProps: { value: _vm.date_story },
                          on: {
                            input: function($event) {
                              if ($event.target.composing) {
                                return
                              }
                              _vm.date_story = $event.target.value
                            }
                          }
                        }),
                        _vm._v(" "),
                        _c("span", [_vm._v("at")]),
                        _vm._v(" "),
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: _vm.time_story,
                              expression: "time_story"
                            }
                          ],
                          attrs: { type: "text", placeholder: "17" },
                          domProps: { value: _vm.time_story },
                          on: {
                            input: function($event) {
                              if ($event.target.composing) {
                                return
                              }
                              _vm.time_story = $event.target.value
                            }
                          }
                        }),
                        _vm._v(" "),
                        _c("span", [_vm._v("hrs")])
                      ])
                    ])
                  ]
                )
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "modal-form__actions" }, [
                _c(
                  "button",
                  {
                    staticClass: "btn btn-success",
                    attrs: { disabled: _vm.disableAction() }
                  },
                  [_vm._v("Create")]
                ),
                _vm._v(" "),
                _c(
                  "button",
                  {
                    staticClass: "btn btn-danger",
                    attrs: { type: "button" },
                    on: { click: _vm.dismiss }
                  },
                  [_vm._v("Cancel")]
                )
              ])
            ]
          )
        ])
      ])
    ]
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("header", [
      _c("h4", { staticClass: "heading" }, [_vm._v("Add new Tracker")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("span", [
      _c("i", { staticClass: "fab fa-instagram" }),
      _vm._v(" Instagram")
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("span", [
      _c("i", { staticClass: "fab fa-youtube" }),
      _vm._v(" YouTube")
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/TrackersPage.vue?vue&type=template&id=74593673&":
/*!**********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/TrackersPage.vue?vue&type=template&id=74593673& ***!
  \**********************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "trackers" },
    [
      _c("div", { staticClass: "hero" }, [
        _c("div", { staticClass: "hero__intro" }, [
          _c("h1", [
            _vm._v(
              _vm._s(
                _vm.tracker && _vm.tracker.name
                  ? _vm.tracker.name.toUpperCase()
                  : "Trackers"
              )
            )
          ]),
          _vm._v(" "),
          _vm._m(0)
        ]),
        _vm._v(" "),
        !_vm.tracker
          ? _c("div", { staticClass: "hero__actions" }, [
              _c(
                "button",
                {
                  staticClass: "btn btn-success",
                  attrs: {
                    disabled:
                      !_vm.campaigns ||
                      typeof _vm.campaigns.length === "undefined" ||
                      _vm.campaigns.length === 0
                  },
                  on: {
                    click: function($event) {
                      _vm.showAddTrackerModal = !_vm.showAddTrackerModal
                    }
                  }
                },
                [_vm._v("Add new tracker")]
              )
            ])
          : _vm._e()
      ]),
      _vm._v(" "),
      !_vm.tracker
        ? _c("div", { staticClass: "p-1" }, [
            _c("header", { staticClass: "cards" }, [
              _c("div", { staticClass: "card" }, [
                _c("div", { staticClass: "number" }, [
                  _vm._v(_vm._s(_vm._f("formatedNbr")(_vm.trackers.length)))
                ]),
                _vm._v(" "),
                _c("p", { staticClass: "description" }, [
                  _vm._v("NUMBER OF TRACKERS")
                ])
              ])
            ]),
            _vm._v(" "),
            _c("section", { staticClass: "actions-card" }, [
              _c("h4", [_vm._v("Trackers list for")]),
              _vm._v(" "),
              _c(
                "select",
                {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.selectedCampaign,
                      expression: "selectedCampaign"
                    }
                  ],
                  on: {
                    change: [
                      function($event) {
                        var $$selectedVal = Array.prototype.filter
                          .call($event.target.options, function(o) {
                            return o.selected
                          })
                          .map(function(o) {
                            var val = "_value" in o ? o._value : o.value
                            return val
                          })
                        _vm.selectedCampaign = $event.target.multiple
                          ? $$selectedVal
                          : $$selectedVal[0]
                      },
                      function($event) {
                        return _vm.loadByCampaign()
                      }
                    ]
                  }
                },
                [
                  _c(
                    "option",
                    { attrs: { selected: "" }, domProps: { value: null } },
                    [_vm._v("all campaigns")]
                  ),
                  _vm._v(" "),
                  _vm._l(_vm.campaigns, function(camp) {
                    return _c(
                      "option",
                      { key: camp.id, domProps: { value: camp } },
                      [_vm._v(_vm._s(camp.name))]
                    )
                  })
                ],
                2
              )
            ]),
            _vm._v(" "),
            _vm.$can("list", "tracker") ||
            (_vm.AuthenticatedUser && _vm.AuthenticatedUser.is_superadmin)
              ? _c(
                  "div",
                  { staticClass: "datatable-scroll" },
                  [
                    _c(
                      "DataTable",
                      {
                        ref: "trackersDT",
                        attrs: {
                          columns: _vm.columns,
                          searchable: true,
                          searchCols: ["name", "username"],
                          nativeData: _vm.trackers,
                          fetchMethod: "fetchTrackers",
                          cssClasses: "table-card"
                        },
                        scopedSlots: _vm._u(
                          [
                            {
                              key: "body-row",
                              fn: function(row) {
                                return _c(
                                  "td",
                                  {},
                                  [
                                    _vm.$can("analytics", "tracker") ||
                                    (_vm.AuthenticatedUser &&
                                      _vm.AuthenticatedUser.is_superadmin)
                                      ? _c(
                                          "router-link",
                                          {
                                            directives: [
                                              {
                                                name: "show",
                                                rawName: "v-show",
                                                value:
                                                  row.data.original.queued ===
                                                  "finished",
                                                expression:
                                                  "row.data.original.queued === 'finished'"
                                              }
                                            ],
                                            staticClass: "icon-link",
                                            attrs: {
                                              to: {
                                                name: "trackers",
                                                params: {
                                                  uuid: row.data.original.uuid
                                                }
                                              },
                                              title: "Statistics"
                                            }
                                          },
                                          [
                                            _c("i", {
                                              staticClass:
                                                "far fa-chart-bar datatable-icon"
                                            })
                                          ]
                                        )
                                      : _vm._e(),
                                    _vm._v(" "),
                                    (_vm.$can("show", "tracker") ||
                                      (_vm.AuthenticatedUser &&
                                        _vm.AuthenticatedUser.is_superadmin)) &&
                                    row.data.original.type == "url"
                                      ? _c(
                                          "button",
                                          {
                                            staticClass: "btn icon-link",
                                            attrs: { title: "Copy shortlink" },
                                            on: {
                                              click: function($event) {
                                                return _vm.copyShortlink(
                                                  row.data.original
                                                )
                                              }
                                            }
                                          },
                                          [
                                            _c("i", {
                                              staticClass:
                                                "fas fa-link datatable-icon"
                                            })
                                          ]
                                        )
                                      : _vm._e(),
                                    _vm._v(" "),
                                    _vm.$can("change-status", "tracker") ||
                                    (_vm.AuthenticatedUser &&
                                      _vm.AuthenticatedUser.is_superadmin)
                                      ? _c(
                                          "button",
                                          {
                                            staticClass: "btn icon-link",
                                            attrs: {
                                              title:
                                                (row.data.original.status
                                                  ? "Stop"
                                                  : "Start") + " tracker"
                                            },
                                            on: {
                                              click: function($event) {
                                                return _vm.enableTracker(
                                                  row.data.original
                                                )
                                              }
                                            }
                                          },
                                          [
                                            _c(
                                              "svg",
                                              {
                                                directives: [
                                                  {
                                                    name: "show",
                                                    rawName: "v-show",
                                                    value:
                                                      row.data.original.status,
                                                    expression:
                                                      "row.data.original.status"
                                                  }
                                                ],
                                                staticClass:
                                                  "svg-inline--fa fa-stop-circle fa-w-16",
                                                attrs: {
                                                  "data-v-4b997e69": "",
                                                  "aria-hidden": "true",
                                                  focusable: "false",
                                                  "data-prefix": "far",
                                                  "data-icon": "stop-circle",
                                                  role: "img",
                                                  xmlns:
                                                    "http://www.w3.org/2000/svg",
                                                  viewBox: "0 0 512 512",
                                                  "data-fa-i2svg": ""
                                                }
                                              },
                                              [
                                                _c("path", {
                                                  attrs: {
                                                    fill: "currentColor",
                                                    d:
                                                      "M504 256C504 119 393 8 256 8S8 119 8 256s111 248 248 248 248-111 248-248zm-448 0c0-110.5 89.5-200 200-200s200 89.5 200 200-89.5 200-200 200S56 366.5 56 256zm296-80v160c0 8.8-7.2 16-16 16H176c-8.8 0-16-7.2-16-16V176c0-8.8 7.2-16 16-16h160c8.8 0 16 7.2 16 16z"
                                                  }
                                                })
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "svg",
                                              {
                                                directives: [
                                                  {
                                                    name: "show",
                                                    rawName: "v-show",
                                                    value: !row.data.original
                                                      .status,
                                                    expression:
                                                      "!row.data.original.status"
                                                  }
                                                ],
                                                staticClass:
                                                  "svg-inline--fa fa-play-circle fa-w-16",
                                                attrs: {
                                                  "data-v-4b997e69": "",
                                                  "aria-hidden": "true",
                                                  focusable: "false",
                                                  "data-prefix": "far",
                                                  "data-icon": "play-circle",
                                                  role: "img",
                                                  xmlns:
                                                    "http://www.w3.org/2000/svg",
                                                  viewBox: "0 0 512 512",
                                                  "data-fa-i2svg": ""
                                                }
                                              },
                                              [
                                                _c("path", {
                                                  attrs: {
                                                    fill: "currentColor",
                                                    d:
                                                      "M371.7 238l-176-107c-15.8-8.8-35.7 2.5-35.7 21v208c0 18.4 19.8 29.8 35.7 21l176-101c16.4-9.1 16.4-32.8 0-42zM504 256C504 119 393 8 256 8S8 119 8 256s111 248 248 248 248-111 248-248zm-448 0c0-110.5 89.5-200 200-200s200 89.5 200 200-89.5 200-200 200S56 366.5 56 256z"
                                                  }
                                                })
                                              ]
                                            )
                                          ]
                                        )
                                      : _vm._e(),
                                    _vm._v(" "),
                                    _vm.$can("delete", "tracker") ||
                                    (_vm.AuthenticatedUser &&
                                      _vm.AuthenticatedUser.is_superadmin)
                                      ? _c(
                                          "button",
                                          {
                                            staticClass: "btn icon-link",
                                            attrs: { title: "Delete tracker" },
                                            on: {
                                              click: function($event) {
                                                return _vm.deleteTracker(
                                                  row.data.original
                                                )
                                              }
                                            }
                                          },
                                          [
                                            _c("i", {
                                              staticClass:
                                                "far fa-trash-alt datatable-icon"
                                            })
                                          ]
                                        )
                                      : _vm._e()
                                  ],
                                  1
                                )
                              }
                            }
                          ],
                          null,
                          false,
                          1324104887
                        )
                      },
                      [
                        _c(
                          "th",
                          { attrs: { slot: "header" }, slot: "header" },
                          [_vm._v("Actions")]
                        )
                      ]
                    )
                  ],
                  1
                )
              : _vm._e()
          ])
        : _vm._e(),
      _vm._v(" "),
      _c("CreateTrackerModal", {
        attrs: { show: _vm.showAddTrackerModal, campaigns: _vm.campaigns },
        on: { create: _vm.create, dismiss: _vm.dismissAddTrackerModal }
      }),
      _vm._v(" "),
      _c("ConfirmationModal", {
        ref: "confirmModal",
        on: { custom: _vm.deleteAction }
      }),
      _vm._v(" "),
      _vm.tracker
        ? _c("TrackerAnalytics", { attrs: { tracker: _vm.tracker } })
        : _vm._e()
    ],
    1
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("ul", { staticClass: "breadcrumbs" }, [
      _c("li", [_c("a", { attrs: { href: "#" } }, [_vm._v("Dashboard")])]),
      _vm._v(" "),
      _c("li", [_c("a", { attrs: { href: "#" } }, [_vm._v("Trackers")])])
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/TrackerAnalytics.vue":
/*!******************************************************!*\
  !*** ./resources/js/components/TrackerAnalytics.vue ***!
  \******************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _TrackerAnalytics_vue_vue_type_template_id_adf462ce___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TrackerAnalytics.vue?vue&type=template&id=adf462ce& */ "./resources/js/components/TrackerAnalytics.vue?vue&type=template&id=adf462ce&");
/* harmony import */ var _TrackerAnalytics_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TrackerAnalytics.vue?vue&type=script&lang=js& */ "./resources/js/components/TrackerAnalytics.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _TrackerAnalytics_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _TrackerAnalytics_vue_vue_type_template_id_adf462ce___WEBPACK_IMPORTED_MODULE_0__["render"],
  _TrackerAnalytics_vue_vue_type_template_id_adf462ce___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/TrackerAnalytics.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/TrackerAnalytics.vue?vue&type=script&lang=js&":
/*!*******************************************************************************!*\
  !*** ./resources/js/components/TrackerAnalytics.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TrackerAnalytics_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./TrackerAnalytics.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/TrackerAnalytics.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TrackerAnalytics_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/TrackerAnalytics.vue?vue&type=template&id=adf462ce&":
/*!*************************************************************************************!*\
  !*** ./resources/js/components/TrackerAnalytics.vue?vue&type=template&id=adf462ce& ***!
  \*************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TrackerAnalytics_vue_vue_type_template_id_adf462ce___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./TrackerAnalytics.vue?vue&type=template&id=adf462ce& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/TrackerAnalytics.vue?vue&type=template&id=adf462ce&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TrackerAnalytics_vue_vue_type_template_id_adf462ce___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TrackerAnalytics_vue_vue_type_template_id_adf462ce___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/modals/CreateTrackerModal.vue":
/*!***************************************************************!*\
  !*** ./resources/js/components/modals/CreateTrackerModal.vue ***!
  \***************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _CreateTrackerModal_vue_vue_type_template_id_079a9bc2_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./CreateTrackerModal.vue?vue&type=template&id=079a9bc2&scoped=true& */ "./resources/js/components/modals/CreateTrackerModal.vue?vue&type=template&id=079a9bc2&scoped=true&");
/* harmony import */ var _CreateTrackerModal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./CreateTrackerModal.vue?vue&type=script&lang=js& */ "./resources/js/components/modals/CreateTrackerModal.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _CreateTrackerModal_vue_vue_type_style_index_0_id_079a9bc2_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./CreateTrackerModal.vue?vue&type=style&index=0&id=079a9bc2&scoped=true&lang=css& */ "./resources/js/components/modals/CreateTrackerModal.vue?vue&type=style&index=0&id=079a9bc2&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _CreateTrackerModal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _CreateTrackerModal_vue_vue_type_template_id_079a9bc2_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _CreateTrackerModal_vue_vue_type_template_id_079a9bc2_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "079a9bc2",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/modals/CreateTrackerModal.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/modals/CreateTrackerModal.vue?vue&type=script&lang=js&":
/*!****************************************************************************************!*\
  !*** ./resources/js/components/modals/CreateTrackerModal.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateTrackerModal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./CreateTrackerModal.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/modals/CreateTrackerModal.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateTrackerModal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/modals/CreateTrackerModal.vue?vue&type=style&index=0&id=079a9bc2&scoped=true&lang=css&":
/*!************************************************************************************************************************!*\
  !*** ./resources/js/components/modals/CreateTrackerModal.vue?vue&type=style&index=0&id=079a9bc2&scoped=true&lang=css& ***!
  \************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateTrackerModal_vue_vue_type_style_index_0_id_079a9bc2_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/style-loader!../../../../node_modules/css-loader??ref--6-1!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--6-2!../../../../node_modules/vue-loader/lib??vue-loader-options!./CreateTrackerModal.vue?vue&type=style&index=0&id=079a9bc2&scoped=true&lang=css& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/modals/CreateTrackerModal.vue?vue&type=style&index=0&id=079a9bc2&scoped=true&lang=css&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateTrackerModal_vue_vue_type_style_index_0_id_079a9bc2_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateTrackerModal_vue_vue_type_style_index_0_id_079a9bc2_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateTrackerModal_vue_vue_type_style_index_0_id_079a9bc2_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__) if(__WEBPACK_IMPORT_KEY__ !== 'default') (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateTrackerModal_vue_vue_type_style_index_0_id_079a9bc2_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateTrackerModal_vue_vue_type_style_index_0_id_079a9bc2_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0___default.a); 

/***/ }),

/***/ "./resources/js/components/modals/CreateTrackerModal.vue?vue&type=template&id=079a9bc2&scoped=true&":
/*!**********************************************************************************************************!*\
  !*** ./resources/js/components/modals/CreateTrackerModal.vue?vue&type=template&id=079a9bc2&scoped=true& ***!
  \**********************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateTrackerModal_vue_vue_type_template_id_079a9bc2_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./CreateTrackerModal.vue?vue&type=template&id=079a9bc2&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/modals/CreateTrackerModal.vue?vue&type=template&id=079a9bc2&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateTrackerModal_vue_vue_type_template_id_079a9bc2_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateTrackerModal_vue_vue_type_template_id_079a9bc2_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/pages/TrackersPage.vue":
/*!*********************************************!*\
  !*** ./resources/js/pages/TrackersPage.vue ***!
  \*********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _TrackersPage_vue_vue_type_template_id_74593673___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TrackersPage.vue?vue&type=template&id=74593673& */ "./resources/js/pages/TrackersPage.vue?vue&type=template&id=74593673&");
/* harmony import */ var _TrackersPage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TrackersPage.vue?vue&type=script&lang=js& */ "./resources/js/pages/TrackersPage.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _TrackersPage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _TrackersPage_vue_vue_type_template_id_74593673___WEBPACK_IMPORTED_MODULE_0__["render"],
  _TrackersPage_vue_vue_type_template_id_74593673___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/TrackersPage.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/pages/TrackersPage.vue?vue&type=script&lang=js&":
/*!**********************************************************************!*\
  !*** ./resources/js/pages/TrackersPage.vue?vue&type=script&lang=js& ***!
  \**********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TrackersPage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./TrackersPage.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/TrackersPage.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TrackersPage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/TrackersPage.vue?vue&type=template&id=74593673&":
/*!****************************************************************************!*\
  !*** ./resources/js/pages/TrackersPage.vue?vue&type=template&id=74593673& ***!
  \****************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TrackersPage_vue_vue_type_template_id_74593673___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./TrackersPage.vue?vue&type=template&id=74593673& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/TrackersPage.vue?vue&type=template&id=74593673&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TrackersPage_vue_vue_type_template_id_74593673___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TrackersPage_vue_vue_type_template_id_74593673___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);