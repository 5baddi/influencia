(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[7],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/CampaignAnalytics.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/CampaignAnalytics.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
/* harmony import */ var number_abbreviate__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! number-abbreviate */ "./node_modules/number-abbreviate/index.js");
/* harmony import */ var number_abbreviate__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(number_abbreviate__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var chart_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! chart.js */ "./node_modules/chart.js/dist/Chart.js");
/* harmony import */ var chart_js__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(chart_js__WEBPACK_IMPORTED_MODULE_2__);
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
    campaign: {
      type: Object,
      "default": function _default() {
        return {};
      }
    }
  },
  methods: {
    nbr: function nbr() {
      return new number_abbreviate__WEBPACK_IMPORTED_MODULE_1___default.a();
    },
    createDoughtnutChart: function createDoughtnutChart(id, data) {
      var chartEl = document.getElementById(id);
      var chart = new chart_js__WEBPACK_IMPORTED_MODULE_2___default.a(chartEl, {
        type: 'doughnut',
        data: data
      });
    }
  },
  computed: _objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapGetters"])(["AuthenticatedUser"])),
  mounted: function mounted() {
    if (this.campaign !== null) {
      // Comments sentiments
      if (typeof this.campaign.sentiments_positive === 'number' && typeof this.campaign.sentiments_neutral === 'number' && typeof this.campaign.sentiments_negative === 'number') {
        this.createDoughtnutChart('sentiments-chart', {
          datasets: [{
            data: [(this.campaign.sentiments_positive * 100).toFixed(2), (this.campaign.sentiments_neutral * 100).toFixed(2), (this.campaign.sentiments_negative * 100).toFixed(2)],
            backgroundColor: ["#AFD75C", "#999999", "#ED435A" //#d93176
            ]
          }],
          labels: ['Positive ' + (this.campaign.sentiments_positive * 100).toFixed(2), 'Neutral ' + (this.campaign.sentiments_neutral * 100).toFixed(2), 'Negative ' + (this.campaign.sentiments_negative * 100).toFixed(2)]
        });
      } // Communities


      if (this.campaign.communities && this.campaign.communities > 0) {
        this.createDoughtnutChart('communities-chart', {
          datasets: [{
            data: [this.campaign.communities.toFixed(2)],
            backgroundColor: ['#d93176']
          }],
          labels: ['Instagram']
        });
      } // Impressions


      if (this.campaign.impressions && this.campaign.impressions > 0) {
        this.createDoughtnutChart('impressions-chart', {
          datasets: [{
            data: [this.campaign.impressions.toFixed(2)],
            backgroundColor: ['#d93176']
          }],
          labels: ['Instagram']
        });
      } // Videos views


      if (this.campaign.video_views && this.campaign.video_views > 0) {
        this.createDoughtnutChart('views-chart', {
          datasets: [{
            data: [this.campaign.video_views],
            backgroundColor: ['#d93176']
          }],
          labels: ['Instagram']
        });
      } // Engagements


      if (this.campaign.engagements && this.campaign.engagements > 0) {
        this.createDoughtnutChart('engagements-chart', {
          datasets: [{
            data: [this.campaign.engagements.toFixed(2)],
            backgroundColor: ['#d93176']
          }],
          labels: ['Instagram']
        });
      } // Posts


      if (this.campaign.posts_count && this.campaign.posts_count > 0) {
        var postsAndStoriesLabel = 'Instagram: ' + (this.campaign.posts_count ? this.campaign.posts_count : 0) + ' including ' + (this.campaign.stories_count ? this.campaign.stories_count : 0) + ' stories';
        this.createDoughtnutChart('posts-chart', {
          datasets: [{
            data: [this.campaign.posts_count.toFixed(2)],
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
        name: 'Influencer',
        field: 'id',
        callback: function callback(row) {
          return '<p style="display: inline-flex; align-items: center;margin:0"><img src="' + row.pic_url + '" style="margin-right:0.2rem"/>&nbsp;' + (row.name ? row.name : row.username) + '</p>';
        }
      }, {
        name: 'Number of posts',
        field: 'medias',
        isNbr: true
      }, {
        name: 'Engagemnets rate',
        field: 'engagement_rate',
        isPercentage: true
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
      instaPostsColumns: [{
        name: 'Influencer',
        field: 'influencer',
        callback: function callback(row) {
          return '<p style="display: inline-flex; align-items: center;margin:0"><img style="margin-right:0.2rem" src="' + row.influencer.pic_url + '"/>&nbsp;' + (row.influencer.name ? row.influencer.name : row.influencer.username) + '</p>';
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
        field: 'published_at',
        isDate: true,
        format: 'DD/MM/YYYY'
      }, {
        name: 'Earned Media Value',
        field: 'earned_media_value',
        currency: '€'
      }],
      trackersColumns: [{
        name: "name",
        field: "name",
        capitalize: true
      }, {
        name: "Platform",
        field: "platform",
        callback: function callback(row) {
          var link = "";
          var icon = "";

          if (row.platform === "instagram") {
            link = "https://instagram.com/";
            icon = "<i class=\"fab fa-instagram instagram-icon\"></i>";
          } else if (row.platform === "youtube") {
            link = "https://youtube.com/";
            icon = "<i class=\"fab fa-youtube youtube-icon\"></i>";
          }

          return '<a href="' + link + '" target="_blank" title="' + row.platform + '" class="icon-link">' + icon + '</a>';
        }
      }, {
        name: "type",
        field: "type",
        capitalize: true
      }, {
        name: "Status",
        field: "status",
        sortable: false,
        callback: function callback(row) {
          return '<span class="status status-' + (row.status ? 'success' : 'danger') + '" title="' + (row.status ? 'Enabled' : 'Disabled') + '">' + (row.queued.charAt(0).toUpperCase() + row.queued.slice(1)) + '</span>';
        }
      }, {
        name: "Created at",
        field: "created_at",
        isTimeAgo: true
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

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/modals/CreateCampaignModal.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/modals/CreateCampaignModal.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
//
//
//
//
//
//
//
//
//
//
//
//
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
  data: function data() {
    return {
      show: false,
      campaign: {
        uuid: null,
        name: null
      },
      title: "Add new campaign"
    };
  },
  created: function created() {
    var _this = this;

    document.addEventListener("keydown", function (e) {
      if (e.key == "Escape" && _this.show) {
        _this.close();
      }
    });
  },
  methods: {
    open: function open(campaign) {
      if (typeof campaign !== "undefined") this.campaign = campaign;
      if (typeof campaign !== "undefined" && typeof campaign.uuid == "string" && campaign.name !== null) this.title = "Update " + campaign.name.slice();
      this.show = true;
    },
    close: function close() {
      this.show = false;
      this.campaign = {
        uuid: null,
        name: null
      };
      this.title = "Add new campaign";
    },
    submit: function submit() {
      var action = typeof this.campaign.uuid === "undefined" || this.campaign.uuid === null ? "create" : "update"; // Set base campaign info

      var formData = {};
      formData.name = this.campaign.name;
      if (this.campaign.uuid !== null) formData.uuid = this.campaign.uuid;
      this.$emit(action, formData);
      this.close();
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/CampaignsPage.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/CampaignsPage.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _components_modals_CreateCampaignModal__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../components/modals/CreateCampaignModal */ "./resources/js/components/modals/CreateCampaignModal.vue");
/* harmony import */ var _components_CampaignAnalytics__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../components/CampaignAnalytics */ "./resources/js/components/CampaignAnalytics.vue");
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
/* harmony import */ var _components_DataTable_vue__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../components/DataTable.vue */ "./resources/js/components/DataTable.vue");
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




/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    CreateCampaignModal: _components_modals_CreateCampaignModal__WEBPACK_IMPORTED_MODULE_0__["default"],
    CampaignAnalytics: _components_CampaignAnalytics__WEBPACK_IMPORTED_MODULE_1__["default"]
  },
  notifications: {
    showError: {
      type: "error",
      title: "Error",
      message: "Something going wrong! Please try again.."
    },
    showSuccess: {
      type: "success"
    },
    createCampaignErrors: {
      type: "error"
    },
    createCampaignSuccess: {
      type: "success"
    }
  },
  methods: {
    loadCampaigns: function loadCampaigns() {
      // Load campaigns
      if (Object.values(this.campaigns).length === 0) this.$store.dispatch("fetchCampaigns")["catch"](function (error) {});
    },
    fetchCampaign: function fetchCampaign() {
      // Load campaign analytics by UUID
      this.$store.dispatch("fetchCampaignAnalytics", this.$route.params.uuid)["catch"](function (error) {});
    },
    addCampaign: function addCampaign() {
      this.$refs.campaignFormModal.open();
    },
    editCampaign: function editCampaign(campaign) {
      this.$refs.campaignFormModal.open(Object.assign({}, campaign));
    },
    deleteCampaign: function deleteCampaign(campaign) {
      this.$refs.confirmDeleteCampaignModal.open("Are sure to delete this campaign?", campaign);
    },
    deleteCampaignAction: function deleteCampaignAction(campaign) {
      var _this = this;

      if (typeof campaign.uuid === "undefined") this.showError();
      this.$store.dispatch("deleteCampaign", campaign.uuid).then(function (response) {
        _this.$refs.campaignsDT.reloadData();

        _this.showSuccess({
          message: "Successfully deleted campaign '" + campaign.name + "'"
        });
      })["catch"](function (error) {
        _this.showError({
          message: error.message
        });
      });
    },
    create: function create(campaign) {
      var _this2 = this;

      // Set brand ID
      campaign.brand_id = this.AuthenticatedUser.selected_brand_id;
      this.$store.dispatch("addNewCampaign", campaign).then(function (response) {
        _this2.$refs.campaignsDT.reloadData();

        _this2.showSuccess({
          message: response.message
        });
      })["catch"](function (error) {
        _this2.showError({
          message: error.response.data.message
        });
      });
    },
    update: function update(campaign) {
      var _this3 = this;

      this.$store.dispatch("updateCampaign", campaign).then(function (response) {
        _this3.$refs.campaignsDT.reloadData();

        _this3.showSuccess({
          message: response.message
        });
      })["catch"](function (error) {
        _this3.showError({
          message: error.response.data.message
        });
      });
    }
  },
  computed: _objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_2__["mapGetters"])(["AuthenticatedUser", "campaigns", "campaign"])), {}, {
    parsedCampaigns: function parsedCampaigns() {
      return this.campaigns;
    },
    activeBrand: function activeBrand() {
      if (this.AuthenticatedUser !== null && typeof this.AuthenticatedUser !== "undefined" && this.AuthenticatedUser.selected_brand) return this.AuthenticatedUser.selected_brand;
      return null;
    }
  }),
  watch: {
    "$route.params.uuid": function $routeParamsUuid(value) {
      // Load campaign analytics or unset campaign state
      if (typeof value !== "undefined") this.fetchCampaign();else this.$store.commit("setCampaign", {
        campaign: null
      });
    }
  },
  mounted: function mounted() {
    // Load campaign analytics
    if (typeof this.$route.params.uuid !== "undefined") {
      this.fetchCampaign();
    } else {
      // Unset campaign state
      this.$store.commit("setCampaign", {
        campaign: null
      }); // Load campaigns

      if (typeof this.campaigns === "undefined" || this.campaigns === null || Object.values(this.campaigns).length === 0) this.loadCampaigns();
    }
  },
  data: function data() {
    return {
      columns: [{
        name: "Campaign name",
        field: "name"
      }, {
        name: "Status",
        field: "status",
        sortable: false,
        callback: function callback(row) {
          return '<span class="status status-' + (row.status ? 'success' : 'danger') + '" title="' + (row.status ? 'Running' : 'Paused') + '">' + (row.status ? 'Running' : 'Paused') + '</span>';
        }
      }, {
        name: "Activated communities",
        field: "communities",
        isNbr: true
      }, {
        name: "Number of trackers",
        field: "trackers_count",
        isNbr: true
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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/CampaignAnalytics.vue?vue&type=template&id=419a9e7b&":
/*!********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/CampaignAnalytics.vue?vue&type=template&id=419a9e7b& ***!
  \********************************************************************************************************************************************************************************************************************/
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
  return _vm.campaign
    ? _c("div", { staticClass: "campaign" }, [
        _c(
          "ul",
          {
            directives: [
              {
                name: "show",
                rawName: "v-show",
                value:
                  typeof _vm.campaign.influencers !== "undefined" &&
                  _vm.campaign.influencers.length > 0,
                expression:
                  "typeof campaign.influencers !== 'undefined' && campaign.influencers.length > 0"
              }
            ],
            staticClass: "influencers-avatars"
          },
          [
            _c("h4", [_vm._v("influencers")]),
            _vm._v(" "),
            _vm._l(_vm.campaign.influencers, function(influencer) {
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
                        title: influencer.username
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
          _vm.campaign.communities > 0
            ? _c("div", { staticClass: "card" }, [
                _c("div", { staticClass: "title" }, [
                  _c("i", { staticClass: "fas fa-users egg-blue" }),
                  _vm._v(" "),
                  _c("div", { staticClass: "numbers" }, [
                    _c("h4", [
                      _vm._v(
                        _vm._s(_vm._f("formatedNbr")(_vm.campaign.communities))
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
          _vm.campaign.impressions > 0
            ? _c("div", { staticClass: "card" }, [
                _c("div", { staticClass: "title" }, [
                  _c("i", { staticClass: "fas fa-bullhorn purple" }),
                  _vm._v(" "),
                  _c("div", { staticClass: "numbers" }, [
                    _c("h4", [
                      _vm._v(
                        _vm._s(_vm._f("formatedNbr")(_vm.campaign.impressions))
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
                          _vm.nbr().abbreviate(_vm.campaign.organic_impressions)
                        ).toUpperCase()
                      ) +
                      " (" +
                      _vm._s(
                        _vm.campaign.impressions > 0
                          ? (
                              (_vm.campaign.organic_impressions /
                                _vm.campaign.impressions) *
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
          _vm.campaign.video_views > 0
            ? _c("div", { staticClass: "card" }, [
                _c("div", { staticClass: "title" }, [
                  _c("i", { staticClass: "far fa-eye green" }),
                  _vm._v(" "),
                  _c("div", { staticClass: "numbers" }, [
                    _c("h4", [
                      _vm._v(
                        _vm._s(_vm._f("formatedNbr")(_vm.campaign.video_views))
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
                          _vm.nbr().abbreviate(_vm.campaign.organic_video_views)
                        ).toUpperCase()
                      ) +
                      " (" +
                      _vm._s(
                        _vm.campaign.video_views > 0
                          ? (
                              (_vm.campaign.organic_video_views /
                                _vm.campaign.video_views) *
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
          _vm.campaign.engagements > 0
            ? _c("div", { staticClass: "card" }, [
                _c("div", { staticClass: "title" }, [
                  _c("i", { staticClass: "fas fa-thumbs-up blue" }),
                  _vm._v(" "),
                  _c("div", { staticClass: "numbers" }, [
                    _c("h4", [
                      _vm._v(
                        _vm._s(_vm._f("formatedNbr")(_vm.campaign.engagements))
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
                          _vm.nbr().abbreviate(_vm.campaign.organic_engagements)
                        ).toUpperCase()
                      ) +
                      " (" +
                      _vm._s(
                        _vm.campaign.engagements > 0
                          ? (
                              (_vm.campaign.organic_engagements /
                                _vm.campaign.engagements) *
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
          _vm.campaign.posts_count > 0
            ? _c("div", { staticClass: "card" }, [
                _c("div", { staticClass: "title" }, [
                  _c("i", { staticClass: "fas fa-hashtag yellow" }),
                  _vm._v(" "),
                  _c("div", { staticClass: "numbers" }, [
                    _c("h4", [
                      _vm._v(
                        _vm._s(_vm._f("formatedNbr")(_vm.campaign.posts_count))
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
                          _vm.nbr().abbreviate(_vm.campaign.organic_posts)
                        ).toUpperCase()
                      ) +
                      " (" +
                      _vm._s(
                        _vm.campaign.posts_count > 0
                          ? (
                              (_vm.campaign.organic_posts /
                                _vm.campaign.posts_count) *
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
          _vm.campaign.comments_count > 0
            ? _c("div", { staticClass: "card" }, [
                _c("h5", [_vm._v("Comments sentiment")]),
                _vm._v(" "),
                _c("canvas", { attrs: { id: "sentiments-chart" } }),
                _vm._v(" "),
                _c("span", [
                  _vm._v(
                    "Based on " +
                      _vm._s(
                        _vm._f("formatedNbr")(_vm.campaign.comments_count)
                      ) +
                      " comments"
                  )
                ])
              ])
            : _vm._e(),
          _vm._v(" "),
          _vm.campaign.top_emojis
            ? _c("div", { staticClass: "card emojis" }, [
                _c("h5", [
                  _vm._v(
                    "Top " +
                      _vm._s(
                        _vm.campaign.top_emojis.top &&
                          Object.values(_vm.campaign.top_emojis.top).length > 1
                          ? Object.values(_vm.campaign.top_emojis.top).length +
                              " "
                          : ""
                      ) +
                      "used emojis"
                  )
                ]),
                _vm._v(" "),
                _c(
                  "ul",
                  _vm._l(_vm.campaign.top_emojis.top, function(count, emoji) {
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
                                (_vm.campaign.top_emojis.all
                                  ? _vm.campaign.top_emojis.all
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
                        _vm._f("formatedNbr")(_vm.campaign.top_emojis.all)
                      ) +
                      " emojis"
                  )
                ])
              ])
            : _vm._e()
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "datatable-scroll" },
          [
            _c("h4", [_vm._v("Performance breakdown by Influencer")]),
            _vm._v(" "),
            _c("DataTable", {
              ref: "byInfluencer",
              attrs: {
                cssClasses: "table-card",
                columns: _vm.influencersColumns,
                nativeData: _vm.campaign.influencers
              }
            })
          ],
          1
        ),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "datatable-scroll" },
          [
            _c("h4", [_vm._v("Performance breakdown by post on Instagram")]),
            _vm._v(" "),
            _c("DataTable", {
              ref: "byInstaPosts",
              attrs: {
                cssClasses: "table-card",
                columns: _vm.instaPostsColumns,
                nativeData: _vm.campaign.instagram_media
              }
            })
          ],
          1
        ),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "datatable-scroll" },
          [
            _c("h4", [_vm._v("List of trackers")]),
            _vm._v(" "),
            _c(
              "DataTable",
              {
                ref: "byTrackers",
                attrs: {
                  cssClasses: "table-card",
                  columns: _vm.trackersColumns,
                  nativeData: _vm.campaign.trackers
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
                                        params: { uuid: row.data.original.uuid }
                                      },
                                      title: "Statistics"
                                    }
                                  },
                                  [_c("i", { staticClass: "far fa-chart-bar" })]
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
                  3662718142
                )
              },
              [
                _c("th", { attrs: { slot: "header" }, slot: "header" }, [
                  _vm._v("Actions")
                ])
              ]
            )
          ],
          1
        ),
        _vm._v(" "),
        _vm.campaign && _vm.campaign.posts_count > 0
          ? _c("div", { staticClass: "posts-section" }, [
              _c("h4", [_vm._v("Posts")]),
              _vm._v(" "),
              _c("p", [
                _vm._v(
                  "There are " +
                    _vm._s(
                      _vm.campaign && _vm.campaign.posts_count
                        ? _vm.campaign.posts_count
                        : 0
                    ) +
                    " posts for this campaign."
                )
              ]),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "campaign-posts" },
                _vm._l(_vm.campaign.media, function(media) {
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
                        media.platform === "instagram"
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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/modals/CreateCampaignModal.vue?vue&type=template&id=1cd11a23&":
/*!*****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/modals/CreateCampaignModal.vue?vue&type=template&id=1cd11a23& ***!
  \*****************************************************************************************************************************************************************************************************************************/
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
        _c("header", [
          _c("h4", { staticClass: "heading" }, [_vm._v(_vm._s(_vm.title))])
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "modal-form" }, [
          _c("form", [
            _c("div", { staticClass: "control" }, [
              _c("input", {
                attrs: { type: "hidden" },
                domProps: { value: _vm.campaign.uuid }
              }),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.campaign.name,
                    expression: "campaign.name"
                  }
                ],
                attrs: {
                  type: "text",
                  placeholder: "Campaign name (e.g. #FashionWeek20)"
                },
                domProps: { value: _vm.campaign.name },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.$set(_vm.campaign, "name", $event.target.value)
                  }
                }
              })
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "modal-form__actions" }, [
              _c(
                "button",
                {
                  staticClass: "btn btn-success",
                  on: {
                    click: function($event) {
                      $event.preventDefault()
                      return _vm.submit()
                    }
                  }
                },
                [
                  _vm._v(
                    _vm._s(
                      typeof _vm.campaign.uuid == "string" ? "Update" : "Create"
                    )
                  )
                ]
              ),
              _vm._v(" "),
              _c(
                "button",
                {
                  staticClass: "btn btn-danger",
                  on: {
                    click: function($event) {
                      $event.preventDefault()
                      return _vm.close()
                    }
                  }
                },
                [_vm._v("Cancel")]
              )
            ])
          ])
        ])
      ])
    ]
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/CampaignsPage.vue?vue&type=template&id=3a199ed9&":
/*!***********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/CampaignsPage.vue?vue&type=template&id=3a199ed9& ***!
  \***********************************************************************************************************************************************************************************************************/
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
    { staticClass: "campaigns" },
    [
      _c("div", { staticClass: "hero" }, [
        _c("div", { staticClass: "hero__intro" }, [
          _c("h1", [
            _vm._v(
              _vm._s(
                _vm.campaign && _vm.campaign.name
                  ? _vm.campaign.name.toUpperCase()
                  : "campaigns"
              )
            )
          ]),
          _vm._v(" "),
          _vm._m(0)
        ]),
        _vm._v(" "),
        (_vm.$can("create", "campaign") ||
          (_vm.AuthenticatedUser && _vm.AuthenticatedUser.is_superadmin)) &&
        !_vm.campaign
          ? _c("div", { staticClass: "hero__actions" }, [
              _c(
                "button",
                {
                  staticClass: "btn btn-success",
                  attrs: { disabled: !_vm.activeBrand },
                  on: {
                    click: function($event) {
                      return _vm.addCampaign()
                    }
                  }
                },
                [_vm._v("Add new campaign")]
              )
            ])
          : _vm._e()
      ]),
      _vm._v(" "),
      !_vm.campaign
        ? _c("div", { staticClass: "p-1" }, [
            _vm.$can("analytics", "campaign") ||
            (_vm.AuthenticatedUser && _vm.AuthenticatedUser.is_superadmin)
              ? _c("header", { staticClass: "cards" }, [
                  _c("div", { staticClass: "card" }, [
                    _c("div", { staticClass: "number" }, [
                      _vm._v(
                        _vm._s(_vm._f("formatedNbr")(_vm.campaigns.length))
                      )
                    ]),
                    _vm._v(" "),
                    _c("p", { staticClass: "description" }, [
                      _vm._v("NUMBER OF CAMPAIGNS")
                    ])
                  ])
                ])
              : _vm._e(),
            _vm._v(" "),
            _vm.$can("list", "campaign") ||
            (_vm.AuthenticatedUser && _vm.AuthenticatedUser.is_superadmin)
              ? _c(
                  "div",
                  { staticClass: "datatable-scroll" },
                  [
                    _c(
                      "DataTable",
                      {
                        ref: "campaignsDT",
                        attrs: {
                          columns: _vm.columns,
                          searchable: true,
                          searchCols: ["name", "influencer"],
                          nativeData: _vm.parsedCampaigns,
                          fetchMethod: "fetchCampaigns",
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
                                    _vm.$can("analytics", "campaign") ||
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
                                                  row.data.original
                                                    .trackers_count > 0,
                                                expression:
                                                  "row.data.original.trackers_count > 0"
                                              }
                                            ],
                                            staticClass: "icon-link",
                                            attrs: {
                                              to: {
                                                name: "campaigns",
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
                                    _vm.$can("list", "tracker") ||
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
                                                  row.data.original
                                                    .trackers_count > 0,
                                                expression:
                                                  "row.data.original.trackers_count > 0"
                                              }
                                            ],
                                            staticClass: "icon-link",
                                            attrs: {
                                              to: {
                                                name: "campaign_trackers",
                                                params: {
                                                  campaign:
                                                    row.data.original.uuid
                                                }
                                              },
                                              title: "Show trackers"
                                            }
                                          },
                                          [
                                            _c("i", {
                                              staticClass: "fas fa-list"
                                            })
                                          ]
                                        )
                                      : _vm._e(),
                                    _vm._v(" "),
                                    _vm.$can("edit", "campaign") ||
                                    (_vm.AuthenticatedUser &&
                                      _vm.AuthenticatedUser.is_superadmin)
                                      ? _c(
                                          "button",
                                          {
                                            staticClass: "btn icon-link",
                                            attrs: { title: "Edit campaign" },
                                            on: {
                                              click: function($event) {
                                                return _vm.editCampaign(
                                                  row.data.original
                                                )
                                              }
                                            }
                                          },
                                          [
                                            _c("i", {
                                              staticClass:
                                                "fas fa-pen datatable-icon"
                                            })
                                          ]
                                        )
                                      : _vm._e(),
                                    _vm._v(" "),
                                    _vm.$can(
                                      "start-stop-tracking",
                                      "campaign"
                                    ) ||
                                    (_vm.AuthenticatedUser &&
                                      _vm.AuthenticatedUser.is_superadmin)
                                      ? _c(
                                          "button",
                                          {
                                            staticClass: "btn icon-link",
                                            attrs: { title: "Stop tracking" },
                                            on: {
                                              click: function($event) {
                                                return _vm.disableCampaign(row)
                                              }
                                            }
                                          },
                                          [
                                            _c("i", {
                                              staticClass:
                                                "far fa-stop-circle datatable-icon"
                                            })
                                          ]
                                        )
                                      : _vm._e(),
                                    _vm._v(" "),
                                    _vm.$can("delete", "campaign") ||
                                    (_vm.AuthenticatedUser &&
                                      _vm.AuthenticatedUser.is_superadmin)
                                      ? _c(
                                          "button",
                                          {
                                            staticClass: "btn icon-link",
                                            attrs: { title: "Delete campaign" },
                                            on: {
                                              click: function($event) {
                                                return _vm.deleteCampaign(
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
                          1545961479
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
      _c("CreateCampaignModal", {
        ref: "campaignFormModal",
        on: { create: _vm.create, update: _vm.update }
      }),
      _vm._v(" "),
      _vm.campaign
        ? _c("CampaignAnalytics", { attrs: { campaign: _vm.campaign } })
        : _vm._e(),
      _vm._v(" "),
      _c("ConfirmationModal", {
        ref: "confirmDeleteCampaignModal",
        on: { custom: _vm.deleteCampaignAction }
      })
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
      _c("li", [_c("a", { attrs: { href: "#" } }, [_vm._v("Campaigns")])])
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/CampaignAnalytics.vue":
/*!*******************************************************!*\
  !*** ./resources/js/components/CampaignAnalytics.vue ***!
  \*******************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _CampaignAnalytics_vue_vue_type_template_id_419a9e7b___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./CampaignAnalytics.vue?vue&type=template&id=419a9e7b& */ "./resources/js/components/CampaignAnalytics.vue?vue&type=template&id=419a9e7b&");
/* harmony import */ var _CampaignAnalytics_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./CampaignAnalytics.vue?vue&type=script&lang=js& */ "./resources/js/components/CampaignAnalytics.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _CampaignAnalytics_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _CampaignAnalytics_vue_vue_type_template_id_419a9e7b___WEBPACK_IMPORTED_MODULE_0__["render"],
  _CampaignAnalytics_vue_vue_type_template_id_419a9e7b___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/CampaignAnalytics.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/CampaignAnalytics.vue?vue&type=script&lang=js&":
/*!********************************************************************************!*\
  !*** ./resources/js/components/CampaignAnalytics.vue?vue&type=script&lang=js& ***!
  \********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CampaignAnalytics_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./CampaignAnalytics.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/CampaignAnalytics.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CampaignAnalytics_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/CampaignAnalytics.vue?vue&type=template&id=419a9e7b&":
/*!**************************************************************************************!*\
  !*** ./resources/js/components/CampaignAnalytics.vue?vue&type=template&id=419a9e7b& ***!
  \**************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CampaignAnalytics_vue_vue_type_template_id_419a9e7b___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./CampaignAnalytics.vue?vue&type=template&id=419a9e7b& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/CampaignAnalytics.vue?vue&type=template&id=419a9e7b&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CampaignAnalytics_vue_vue_type_template_id_419a9e7b___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CampaignAnalytics_vue_vue_type_template_id_419a9e7b___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/modals/CreateCampaignModal.vue":
/*!****************************************************************!*\
  !*** ./resources/js/components/modals/CreateCampaignModal.vue ***!
  \****************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _CreateCampaignModal_vue_vue_type_template_id_1cd11a23___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./CreateCampaignModal.vue?vue&type=template&id=1cd11a23& */ "./resources/js/components/modals/CreateCampaignModal.vue?vue&type=template&id=1cd11a23&");
/* harmony import */ var _CreateCampaignModal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./CreateCampaignModal.vue?vue&type=script&lang=js& */ "./resources/js/components/modals/CreateCampaignModal.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _CreateCampaignModal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _CreateCampaignModal_vue_vue_type_template_id_1cd11a23___WEBPACK_IMPORTED_MODULE_0__["render"],
  _CreateCampaignModal_vue_vue_type_template_id_1cd11a23___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/modals/CreateCampaignModal.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/modals/CreateCampaignModal.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************!*\
  !*** ./resources/js/components/modals/CreateCampaignModal.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateCampaignModal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./CreateCampaignModal.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/modals/CreateCampaignModal.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateCampaignModal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/modals/CreateCampaignModal.vue?vue&type=template&id=1cd11a23&":
/*!***********************************************************************************************!*\
  !*** ./resources/js/components/modals/CreateCampaignModal.vue?vue&type=template&id=1cd11a23& ***!
  \***********************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateCampaignModal_vue_vue_type_template_id_1cd11a23___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./CreateCampaignModal.vue?vue&type=template&id=1cd11a23& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/modals/CreateCampaignModal.vue?vue&type=template&id=1cd11a23&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateCampaignModal_vue_vue_type_template_id_1cd11a23___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateCampaignModal_vue_vue_type_template_id_1cd11a23___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/pages/CampaignsPage.vue":
/*!**********************************************!*\
  !*** ./resources/js/pages/CampaignsPage.vue ***!
  \**********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _CampaignsPage_vue_vue_type_template_id_3a199ed9___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./CampaignsPage.vue?vue&type=template&id=3a199ed9& */ "./resources/js/pages/CampaignsPage.vue?vue&type=template&id=3a199ed9&");
/* harmony import */ var _CampaignsPage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./CampaignsPage.vue?vue&type=script&lang=js& */ "./resources/js/pages/CampaignsPage.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _CampaignsPage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _CampaignsPage_vue_vue_type_template_id_3a199ed9___WEBPACK_IMPORTED_MODULE_0__["render"],
  _CampaignsPage_vue_vue_type_template_id_3a199ed9___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/CampaignsPage.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/pages/CampaignsPage.vue?vue&type=script&lang=js&":
/*!***********************************************************************!*\
  !*** ./resources/js/pages/CampaignsPage.vue?vue&type=script&lang=js& ***!
  \***********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CampaignsPage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./CampaignsPage.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/CampaignsPage.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CampaignsPage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/CampaignsPage.vue?vue&type=template&id=3a199ed9&":
/*!*****************************************************************************!*\
  !*** ./resources/js/pages/CampaignsPage.vue?vue&type=template&id=3a199ed9& ***!
  \*****************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CampaignsPage_vue_vue_type_template_id_3a199ed9___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./CampaignsPage.vue?vue&type=template&id=3a199ed9& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/CampaignsPage.vue?vue&type=template&id=3a199ed9&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CampaignsPage_vue_vue_type_template_id_3a199ed9___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CampaignsPage_vue_vue_type_template_id_3a199ed9___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);