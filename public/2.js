(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[2],{

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

      try {
        var chart = new chart_js__WEBPACK_IMPORTED_MODULE_1___default.a(chartEl, {
          type: 'doughnut',
          data: data
        });
      } catch (e) {
        chartEl.style.display = "none !important";
      }
    }
  },
  mounted: function mounted() {
    if (typeof this.tracker.type !== "undefined" && this.tracker.type === "post") {
      // Comments sentiments
      if (typeof this.tracker.sentiments_positive === 'number' && typeof this.tracker.sentiments_neutral === 'number' && typeof this.tracker.sentiments_negative === 'number') {
        this.createDoughtnutChart('sentiments-chart', {
          datasets: [{
            data: [(this.tracker.sentiments_positive * 100).toFixed(2), (this.tracker.sentiments_neutral * 100).toFixed(2), (this.tracker.sentiments_negative * 100).toFixed(2)],
            backgroundColor: ["#AFD75C", "#999999", "#ED435A" //#d93176
            ]
          }],
          labels: ['Positive ' + (this.tracker.sentiments_positive * 100).toFixed(2), 'Neutral ' + (this.tracker.sentiments_neutral * 100).toFixed(2), 'Negative ' + (this.tracker.sentiments_negative * 100).toFixed(2)]
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
        isImage: true
      }, {
        name: 'Influencer',
        field: 'uuid',
        callback: function callback(row) {
          return row.name ? row.name : row.username;
        }
      }, {
        name: 'Number of posts',
        field: 'campaign_media',
        isNbr: true
      }, {
        name: 'Size of activated communities',
        field: 'estimated_communities',
        isNativeNbr: true
      }, {
        name: 'Estimated impressions',
        field: 'estimated_impressions',
        isNativeNbr: true
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
          return row.influencer.parsed_name ? row.influencer.parsed_name : row.influencer.username;
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
        isNativeNbr: true
      }, {
        name: 'Estimated impressions',
        field: 'estimated_impressions',
        isNativeNbr: true
      }, {
        name: 'Engagements',
        field: 'engagements',
        isNativeNbr: true
      }, {
        name: 'Organic impressions (declarative)',
        field: 'organic_impressions',
        isNativeNbr: true
      }, // {
      //     name: 'Engagements rate (reach)',
      //     field: 'engagement_rate',
      //     callback: function (row) {
      //         return (row.influencer.engagement_rate && row.influencer.engagement_rate > 0) ? (row.influencer.engagement_rate * 100).toFixed(2) : '-';
      //     },
      //     isNativeNbr: true
      // }, 
      {
        name: 'Likes',
        field: 'likes',
        isNativeNbr: true
      }, {
        name: 'Views',
        field: 'video_views',
        isNativeNbr: true
      }, {
        name: 'Comments',
        field: 'comments',
        isNativeNbr: true
      }, {
        name: 'Impressions (first sequence)'
      }, {
        name: 'Story sequences'
      }, {
        name: 'Sequence impressions'
      }, {
        name: 'Tags',
        field: 'tags',
        callback: function callback(row) {
          if (row.tags && row.tags.length > 0) {
            var html = "<ul>";
            row.tags.map(function (item, index) {
              html += '<a href="https://www.instagram.com/explore/tags/' + item + '" tagert="_blank">' + item + '</a>&nbsp;&nbsp;';
            });
            return html + "</ul>";
          }

          return '-';
        }
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

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/TrackersPage.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/TrackersPage.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
/* harmony import */ var _components_TrackerAnalytics__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../components/TrackerAnalytics */ "./resources/js/components/TrackerAnalytics.vue");
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
//


/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    TrackerAnalytics: _components_TrackerAnalytics__WEBPACK_IMPORTED_MODULE_1__["default"]
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
        "class": "influencers-avatars-list",
        sortable: false,
        callback: function callback(row) {
          if (row.influencers.length === 0) return '-';
          var influencers = row.influencers.length > 3 ? row.influencers.slice(0, 3) : row.influencers;
          var html = '';
          influencers.map(function (item, index) {
            html += '<a href="/influencers/' + item.uuid + '" class="avatars-list" title="View ' + (item.name ? item.name : item.username) + ' profile"><img src="' + item.pic_url + '"/>';
          }); // Add more avatar

          if (row.influencers.length > 3) html += '<a href="#" title="' + row.influencers.length + ' Influencers linked"><img src="/images/more.png"/></a>';
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
        isNativeNbr: true
      }, {
        name: "Last update",
        field: "updated_at",
        isTimeAgo: true
      }]
    };
  }
});

/***/ }),

/***/ "./node_modules/moment/locale sync recursive ^\\.\\/.*$":
/*!**************************************************!*\
  !*** ./node_modules/moment/locale sync ^\.\/.*$ ***!
  \**************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var map = {
	"./af": "./node_modules/moment/locale/af.js",
	"./af.js": "./node_modules/moment/locale/af.js",
	"./ar": "./node_modules/moment/locale/ar.js",
	"./ar-dz": "./node_modules/moment/locale/ar-dz.js",
	"./ar-dz.js": "./node_modules/moment/locale/ar-dz.js",
	"./ar-kw": "./node_modules/moment/locale/ar-kw.js",
	"./ar-kw.js": "./node_modules/moment/locale/ar-kw.js",
	"./ar-ly": "./node_modules/moment/locale/ar-ly.js",
	"./ar-ly.js": "./node_modules/moment/locale/ar-ly.js",
	"./ar-ma": "./node_modules/moment/locale/ar-ma.js",
	"./ar-ma.js": "./node_modules/moment/locale/ar-ma.js",
	"./ar-sa": "./node_modules/moment/locale/ar-sa.js",
	"./ar-sa.js": "./node_modules/moment/locale/ar-sa.js",
	"./ar-tn": "./node_modules/moment/locale/ar-tn.js",
	"./ar-tn.js": "./node_modules/moment/locale/ar-tn.js",
	"./ar.js": "./node_modules/moment/locale/ar.js",
	"./az": "./node_modules/moment/locale/az.js",
	"./az.js": "./node_modules/moment/locale/az.js",
	"./be": "./node_modules/moment/locale/be.js",
	"./be.js": "./node_modules/moment/locale/be.js",
	"./bg": "./node_modules/moment/locale/bg.js",
	"./bg.js": "./node_modules/moment/locale/bg.js",
	"./bm": "./node_modules/moment/locale/bm.js",
	"./bm.js": "./node_modules/moment/locale/bm.js",
	"./bn": "./node_modules/moment/locale/bn.js",
	"./bn-bd": "./node_modules/moment/locale/bn-bd.js",
	"./bn-bd.js": "./node_modules/moment/locale/bn-bd.js",
	"./bn.js": "./node_modules/moment/locale/bn.js",
	"./bo": "./node_modules/moment/locale/bo.js",
	"./bo.js": "./node_modules/moment/locale/bo.js",
	"./br": "./node_modules/moment/locale/br.js",
	"./br.js": "./node_modules/moment/locale/br.js",
	"./bs": "./node_modules/moment/locale/bs.js",
	"./bs.js": "./node_modules/moment/locale/bs.js",
	"./ca": "./node_modules/moment/locale/ca.js",
	"./ca.js": "./node_modules/moment/locale/ca.js",
	"./cs": "./node_modules/moment/locale/cs.js",
	"./cs.js": "./node_modules/moment/locale/cs.js",
	"./cv": "./node_modules/moment/locale/cv.js",
	"./cv.js": "./node_modules/moment/locale/cv.js",
	"./cy": "./node_modules/moment/locale/cy.js",
	"./cy.js": "./node_modules/moment/locale/cy.js",
	"./da": "./node_modules/moment/locale/da.js",
	"./da.js": "./node_modules/moment/locale/da.js",
	"./de": "./node_modules/moment/locale/de.js",
	"./de-at": "./node_modules/moment/locale/de-at.js",
	"./de-at.js": "./node_modules/moment/locale/de-at.js",
	"./de-ch": "./node_modules/moment/locale/de-ch.js",
	"./de-ch.js": "./node_modules/moment/locale/de-ch.js",
	"./de.js": "./node_modules/moment/locale/de.js",
	"./dv": "./node_modules/moment/locale/dv.js",
	"./dv.js": "./node_modules/moment/locale/dv.js",
	"./el": "./node_modules/moment/locale/el.js",
	"./el.js": "./node_modules/moment/locale/el.js",
	"./en-au": "./node_modules/moment/locale/en-au.js",
	"./en-au.js": "./node_modules/moment/locale/en-au.js",
	"./en-ca": "./node_modules/moment/locale/en-ca.js",
	"./en-ca.js": "./node_modules/moment/locale/en-ca.js",
	"./en-gb": "./node_modules/moment/locale/en-gb.js",
	"./en-gb.js": "./node_modules/moment/locale/en-gb.js",
	"./en-ie": "./node_modules/moment/locale/en-ie.js",
	"./en-ie.js": "./node_modules/moment/locale/en-ie.js",
	"./en-il": "./node_modules/moment/locale/en-il.js",
	"./en-il.js": "./node_modules/moment/locale/en-il.js",
	"./en-in": "./node_modules/moment/locale/en-in.js",
	"./en-in.js": "./node_modules/moment/locale/en-in.js",
	"./en-nz": "./node_modules/moment/locale/en-nz.js",
	"./en-nz.js": "./node_modules/moment/locale/en-nz.js",
	"./en-sg": "./node_modules/moment/locale/en-sg.js",
	"./en-sg.js": "./node_modules/moment/locale/en-sg.js",
	"./eo": "./node_modules/moment/locale/eo.js",
	"./eo.js": "./node_modules/moment/locale/eo.js",
	"./es": "./node_modules/moment/locale/es.js",
	"./es-do": "./node_modules/moment/locale/es-do.js",
	"./es-do.js": "./node_modules/moment/locale/es-do.js",
	"./es-mx": "./node_modules/moment/locale/es-mx.js",
	"./es-mx.js": "./node_modules/moment/locale/es-mx.js",
	"./es-us": "./node_modules/moment/locale/es-us.js",
	"./es-us.js": "./node_modules/moment/locale/es-us.js",
	"./es.js": "./node_modules/moment/locale/es.js",
	"./et": "./node_modules/moment/locale/et.js",
	"./et.js": "./node_modules/moment/locale/et.js",
	"./eu": "./node_modules/moment/locale/eu.js",
	"./eu.js": "./node_modules/moment/locale/eu.js",
	"./fa": "./node_modules/moment/locale/fa.js",
	"./fa.js": "./node_modules/moment/locale/fa.js",
	"./fi": "./node_modules/moment/locale/fi.js",
	"./fi.js": "./node_modules/moment/locale/fi.js",
	"./fil": "./node_modules/moment/locale/fil.js",
	"./fil.js": "./node_modules/moment/locale/fil.js",
	"./fo": "./node_modules/moment/locale/fo.js",
	"./fo.js": "./node_modules/moment/locale/fo.js",
	"./fr": "./node_modules/moment/locale/fr.js",
	"./fr-ca": "./node_modules/moment/locale/fr-ca.js",
	"./fr-ca.js": "./node_modules/moment/locale/fr-ca.js",
	"./fr-ch": "./node_modules/moment/locale/fr-ch.js",
	"./fr-ch.js": "./node_modules/moment/locale/fr-ch.js",
	"./fr.js": "./node_modules/moment/locale/fr.js",
	"./fy": "./node_modules/moment/locale/fy.js",
	"./fy.js": "./node_modules/moment/locale/fy.js",
	"./ga": "./node_modules/moment/locale/ga.js",
	"./ga.js": "./node_modules/moment/locale/ga.js",
	"./gd": "./node_modules/moment/locale/gd.js",
	"./gd.js": "./node_modules/moment/locale/gd.js",
	"./gl": "./node_modules/moment/locale/gl.js",
	"./gl.js": "./node_modules/moment/locale/gl.js",
	"./gom-deva": "./node_modules/moment/locale/gom-deva.js",
	"./gom-deva.js": "./node_modules/moment/locale/gom-deva.js",
	"./gom-latn": "./node_modules/moment/locale/gom-latn.js",
	"./gom-latn.js": "./node_modules/moment/locale/gom-latn.js",
	"./gu": "./node_modules/moment/locale/gu.js",
	"./gu.js": "./node_modules/moment/locale/gu.js",
	"./he": "./node_modules/moment/locale/he.js",
	"./he.js": "./node_modules/moment/locale/he.js",
	"./hi": "./node_modules/moment/locale/hi.js",
	"./hi.js": "./node_modules/moment/locale/hi.js",
	"./hr": "./node_modules/moment/locale/hr.js",
	"./hr.js": "./node_modules/moment/locale/hr.js",
	"./hu": "./node_modules/moment/locale/hu.js",
	"./hu.js": "./node_modules/moment/locale/hu.js",
	"./hy-am": "./node_modules/moment/locale/hy-am.js",
	"./hy-am.js": "./node_modules/moment/locale/hy-am.js",
	"./id": "./node_modules/moment/locale/id.js",
	"./id.js": "./node_modules/moment/locale/id.js",
	"./is": "./node_modules/moment/locale/is.js",
	"./is.js": "./node_modules/moment/locale/is.js",
	"./it": "./node_modules/moment/locale/it.js",
	"./it-ch": "./node_modules/moment/locale/it-ch.js",
	"./it-ch.js": "./node_modules/moment/locale/it-ch.js",
	"./it.js": "./node_modules/moment/locale/it.js",
	"./ja": "./node_modules/moment/locale/ja.js",
	"./ja.js": "./node_modules/moment/locale/ja.js",
	"./jv": "./node_modules/moment/locale/jv.js",
	"./jv.js": "./node_modules/moment/locale/jv.js",
	"./ka": "./node_modules/moment/locale/ka.js",
	"./ka.js": "./node_modules/moment/locale/ka.js",
	"./kk": "./node_modules/moment/locale/kk.js",
	"./kk.js": "./node_modules/moment/locale/kk.js",
	"./km": "./node_modules/moment/locale/km.js",
	"./km.js": "./node_modules/moment/locale/km.js",
	"./kn": "./node_modules/moment/locale/kn.js",
	"./kn.js": "./node_modules/moment/locale/kn.js",
	"./ko": "./node_modules/moment/locale/ko.js",
	"./ko.js": "./node_modules/moment/locale/ko.js",
	"./ku": "./node_modules/moment/locale/ku.js",
	"./ku.js": "./node_modules/moment/locale/ku.js",
	"./ky": "./node_modules/moment/locale/ky.js",
	"./ky.js": "./node_modules/moment/locale/ky.js",
	"./lb": "./node_modules/moment/locale/lb.js",
	"./lb.js": "./node_modules/moment/locale/lb.js",
	"./lo": "./node_modules/moment/locale/lo.js",
	"./lo.js": "./node_modules/moment/locale/lo.js",
	"./lt": "./node_modules/moment/locale/lt.js",
	"./lt.js": "./node_modules/moment/locale/lt.js",
	"./lv": "./node_modules/moment/locale/lv.js",
	"./lv.js": "./node_modules/moment/locale/lv.js",
	"./me": "./node_modules/moment/locale/me.js",
	"./me.js": "./node_modules/moment/locale/me.js",
	"./mi": "./node_modules/moment/locale/mi.js",
	"./mi.js": "./node_modules/moment/locale/mi.js",
	"./mk": "./node_modules/moment/locale/mk.js",
	"./mk.js": "./node_modules/moment/locale/mk.js",
	"./ml": "./node_modules/moment/locale/ml.js",
	"./ml.js": "./node_modules/moment/locale/ml.js",
	"./mn": "./node_modules/moment/locale/mn.js",
	"./mn.js": "./node_modules/moment/locale/mn.js",
	"./mr": "./node_modules/moment/locale/mr.js",
	"./mr.js": "./node_modules/moment/locale/mr.js",
	"./ms": "./node_modules/moment/locale/ms.js",
	"./ms-my": "./node_modules/moment/locale/ms-my.js",
	"./ms-my.js": "./node_modules/moment/locale/ms-my.js",
	"./ms.js": "./node_modules/moment/locale/ms.js",
	"./mt": "./node_modules/moment/locale/mt.js",
	"./mt.js": "./node_modules/moment/locale/mt.js",
	"./my": "./node_modules/moment/locale/my.js",
	"./my.js": "./node_modules/moment/locale/my.js",
	"./nb": "./node_modules/moment/locale/nb.js",
	"./nb.js": "./node_modules/moment/locale/nb.js",
	"./ne": "./node_modules/moment/locale/ne.js",
	"./ne.js": "./node_modules/moment/locale/ne.js",
	"./nl": "./node_modules/moment/locale/nl.js",
	"./nl-be": "./node_modules/moment/locale/nl-be.js",
	"./nl-be.js": "./node_modules/moment/locale/nl-be.js",
	"./nl.js": "./node_modules/moment/locale/nl.js",
	"./nn": "./node_modules/moment/locale/nn.js",
	"./nn.js": "./node_modules/moment/locale/nn.js",
	"./oc-lnc": "./node_modules/moment/locale/oc-lnc.js",
	"./oc-lnc.js": "./node_modules/moment/locale/oc-lnc.js",
	"./pa-in": "./node_modules/moment/locale/pa-in.js",
	"./pa-in.js": "./node_modules/moment/locale/pa-in.js",
	"./pl": "./node_modules/moment/locale/pl.js",
	"./pl.js": "./node_modules/moment/locale/pl.js",
	"./pt": "./node_modules/moment/locale/pt.js",
	"./pt-br": "./node_modules/moment/locale/pt-br.js",
	"./pt-br.js": "./node_modules/moment/locale/pt-br.js",
	"./pt.js": "./node_modules/moment/locale/pt.js",
	"./ro": "./node_modules/moment/locale/ro.js",
	"./ro.js": "./node_modules/moment/locale/ro.js",
	"./ru": "./node_modules/moment/locale/ru.js",
	"./ru.js": "./node_modules/moment/locale/ru.js",
	"./sd": "./node_modules/moment/locale/sd.js",
	"./sd.js": "./node_modules/moment/locale/sd.js",
	"./se": "./node_modules/moment/locale/se.js",
	"./se.js": "./node_modules/moment/locale/se.js",
	"./si": "./node_modules/moment/locale/si.js",
	"./si.js": "./node_modules/moment/locale/si.js",
	"./sk": "./node_modules/moment/locale/sk.js",
	"./sk.js": "./node_modules/moment/locale/sk.js",
	"./sl": "./node_modules/moment/locale/sl.js",
	"./sl.js": "./node_modules/moment/locale/sl.js",
	"./sq": "./node_modules/moment/locale/sq.js",
	"./sq.js": "./node_modules/moment/locale/sq.js",
	"./sr": "./node_modules/moment/locale/sr.js",
	"./sr-cyrl": "./node_modules/moment/locale/sr-cyrl.js",
	"./sr-cyrl.js": "./node_modules/moment/locale/sr-cyrl.js",
	"./sr.js": "./node_modules/moment/locale/sr.js",
	"./ss": "./node_modules/moment/locale/ss.js",
	"./ss.js": "./node_modules/moment/locale/ss.js",
	"./sv": "./node_modules/moment/locale/sv.js",
	"./sv.js": "./node_modules/moment/locale/sv.js",
	"./sw": "./node_modules/moment/locale/sw.js",
	"./sw.js": "./node_modules/moment/locale/sw.js",
	"./ta": "./node_modules/moment/locale/ta.js",
	"./ta.js": "./node_modules/moment/locale/ta.js",
	"./te": "./node_modules/moment/locale/te.js",
	"./te.js": "./node_modules/moment/locale/te.js",
	"./tet": "./node_modules/moment/locale/tet.js",
	"./tet.js": "./node_modules/moment/locale/tet.js",
	"./tg": "./node_modules/moment/locale/tg.js",
	"./tg.js": "./node_modules/moment/locale/tg.js",
	"./th": "./node_modules/moment/locale/th.js",
	"./th.js": "./node_modules/moment/locale/th.js",
	"./tk": "./node_modules/moment/locale/tk.js",
	"./tk.js": "./node_modules/moment/locale/tk.js",
	"./tl-ph": "./node_modules/moment/locale/tl-ph.js",
	"./tl-ph.js": "./node_modules/moment/locale/tl-ph.js",
	"./tlh": "./node_modules/moment/locale/tlh.js",
	"./tlh.js": "./node_modules/moment/locale/tlh.js",
	"./tr": "./node_modules/moment/locale/tr.js",
	"./tr.js": "./node_modules/moment/locale/tr.js",
	"./tzl": "./node_modules/moment/locale/tzl.js",
	"./tzl.js": "./node_modules/moment/locale/tzl.js",
	"./tzm": "./node_modules/moment/locale/tzm.js",
	"./tzm-latn": "./node_modules/moment/locale/tzm-latn.js",
	"./tzm-latn.js": "./node_modules/moment/locale/tzm-latn.js",
	"./tzm.js": "./node_modules/moment/locale/tzm.js",
	"./ug-cn": "./node_modules/moment/locale/ug-cn.js",
	"./ug-cn.js": "./node_modules/moment/locale/ug-cn.js",
	"./uk": "./node_modules/moment/locale/uk.js",
	"./uk.js": "./node_modules/moment/locale/uk.js",
	"./ur": "./node_modules/moment/locale/ur.js",
	"./ur.js": "./node_modules/moment/locale/ur.js",
	"./uz": "./node_modules/moment/locale/uz.js",
	"./uz-latn": "./node_modules/moment/locale/uz-latn.js",
	"./uz-latn.js": "./node_modules/moment/locale/uz-latn.js",
	"./uz.js": "./node_modules/moment/locale/uz.js",
	"./vi": "./node_modules/moment/locale/vi.js",
	"./vi.js": "./node_modules/moment/locale/vi.js",
	"./x-pseudo": "./node_modules/moment/locale/x-pseudo.js",
	"./x-pseudo.js": "./node_modules/moment/locale/x-pseudo.js",
	"./yo": "./node_modules/moment/locale/yo.js",
	"./yo.js": "./node_modules/moment/locale/yo.js",
	"./zh-cn": "./node_modules/moment/locale/zh-cn.js",
	"./zh-cn.js": "./node_modules/moment/locale/zh-cn.js",
	"./zh-hk": "./node_modules/moment/locale/zh-hk.js",
	"./zh-hk.js": "./node_modules/moment/locale/zh-hk.js",
	"./zh-mo": "./node_modules/moment/locale/zh-mo.js",
	"./zh-mo.js": "./node_modules/moment/locale/zh-mo.js",
	"./zh-tw": "./node_modules/moment/locale/zh-tw.js",
	"./zh-tw.js": "./node_modules/moment/locale/zh-tw.js"
};


function webpackContext(req) {
	var id = webpackContextResolve(req);
	return __webpack_require__(id);
}
function webpackContextResolve(req) {
	if(!__webpack_require__.o(map, req)) {
		var e = new Error("Cannot find module '" + req + "'");
		e.code = 'MODULE_NOT_FOUND';
		throw e;
	}
	return map[req];
}
webpackContext.keys = function webpackContextKeys() {
	return Object.keys(map);
};
webpackContext.resolve = webpackContextResolve;
module.exports = webpackContext;
webpackContext.id = "./node_modules/moment/locale sync recursive ^\\.\\/.*$";

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
                          _vm.nbr().abbreviate(_vm.tracker.organic_video_views)
                        ).toUpperCase()
                      ) +
                      " (" +
                      _vm._s(
                        _vm.tracker.video_views > 0
                          ? (
                              (_vm.tracker.organic_video_views /
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
                      " used emoji"
                  )
                ]),
                _vm._v(" "),
                _c(
                  "ul",
                  _vm._l(_vm.tracker.top_emojis.top, function(count, emoji) {
                    return _c("li", { key: count }, [
                      _vm._v(
                        "\r\n                    " +
                          _vm._s(emoji) +
                          "\r\n                    "
                      ),
                      _c("span", [
                        _vm._v(
                          _vm._s(
                            (
                              (count /
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
                      " emoji"
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
          ? _c(
              "div",
              { staticClass: "hero__actions" },
              [
                _c(
                  "router-link",
                  {
                    staticClass: "btn btn-success",
                    attrs: {
                      disabled:
                        !_vm.campaigns ||
                        typeof _vm.campaigns.length === "undefined" ||
                        _vm.campaigns.length === 0,
                      to: { name: "new_tracker" }
                    }
                  },
                  [
                    _c("i", { staticClass: "fas fa-plus" }),
                    _vm._v(" Add new tracker    \r\n            ")
                  ]
                )
              ],
              1
            )
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