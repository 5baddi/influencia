(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[14],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/DashboardPage.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/DashboardPage.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
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

/* harmony default export */ __webpack_exports__["default"] = ({
  computed: _objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapGetters"])(["AuthenticatedUser", "statistics"])),
  methods: {
    loadStatistics: function loadStatistics() {
      return this.$store.dispatch("fetchStatistics");
    }
  },
  mounted: function mounted() {
    // Load statistics
    if (typeof this.statistics === "undefined" || this.statistics === null || Object.values(this.statistics).length === 0) this.loadStatistics();
  },
  data: function data() {
    return {
      latestCampaignsColumns: [{
        name: "Name",
        field: "name"
      }, {
        name: "Activated Communities",
        field: "communities",
        isNbr: true
      }, {
        name: "ESTIMATED IMPRESSIONS",
        field: "impressions",
        isNbr: true
      }, {
        name: "ENGAGEMENTS",
        field: "engagements",
        isNbr: true
      }, {
        name: "Videos views",
        field: "video_views",
        isNbr: true
      }],
      latestTrackersColumns: [{
        name: "Name",
        field: "name"
      }, {
        name: "Activated Communities",
        field: "communities",
        isNbr: true
      }, {
        name: "ESTIMATED IMPRESSIONS",
        field: "impressions",
        isNbr: true
      }, {
        name: "ENGAGEMENTS",
        field: "engagements",
        isNbr: true
      }, {
        name: "Videos views",
        field: "video_views",
        isNbr: true
      }]
    };
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/DashboardPage.vue?vue&type=template&id=576da70a&":
/*!***********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/DashboardPage.vue?vue&type=template&id=576da70a& ***!
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
  return _c("div", { staticClass: "campaigns" }, [
    _vm._m(0),
    _vm._v(" "),
    _c("div", { staticClass: "p-1" }, [
      _vm.$can("analytics", "campaign") ||
      (_vm.AuthenticatedUser && _vm.AuthenticatedUser.is_superadmin)
        ? _c("div", { staticClass: "cards" }, [
            _c("div", { staticClass: "card purple-card" }, [
              _c("div", { staticClass: "number text-white" }, [
                _vm._v(
                  _vm._s(_vm._f("formatedNbr")(_vm.statistics.impressions))
                )
              ]),
              _vm._v(" "),
              _c("p", { staticClass: "description text-white" }, [
                _vm._v("TOTAL ESTIMATED IMPRESSIONS")
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "card orange-card" }, [
              _c("div", { staticClass: "number text-white" }, [
                _vm._v(
                  _vm._s(_vm._f("formatedNbr")(_vm.statistics.communities))
                )
              ]),
              _vm._v(" "),
              _c("p", { staticClass: "description text-white" }, [
                _vm._v("TOTAL SIZE OF ACTIVATED COMMUNITIES")
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "card green-card" }, [
              _c("div", { staticClass: "number text-white" }, [
                _vm._v(
                  _vm._s(_vm._f("formatedNbr")(_vm.statistics.campaigns_count))
                )
              ]),
              _vm._v(" "),
              _c("p", { staticClass: "description text-white" }, [
                _vm._v("NUMBER OF CAMPAIGNS")
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "card cyan-card" }, [
              _c("div", { staticClass: "number text-white" }, [
                _vm._v(
                  _vm._s(_vm._f("formatedNbr")(_vm.statistics.trackers_count))
                )
              ]),
              _vm._v(" "),
              _c("p", { staticClass: "description text-white" }, [
                _vm._v("NUMBER OF TRACKERS")
              ])
            ])
          ])
        : _vm._e(),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "datatable-scroll" },
        [
          _c("h4", [_vm._v("Latest added campaigns")]),
          _vm._v(" "),
          _c("DataTable", {
            ref: "latestCampaigns",
            attrs: {
              cssClasses: "table-card",
              columns: _vm.latestCampaignsColumns,
              nativeData: _vm.statistics.campaigns,
              withPagination: false
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
          _c("h4", [_vm._v("Latest added trackers")]),
          _vm._v(" "),
          _c("DataTable", {
            ref: "latestTrackers",
            attrs: {
              cssClasses: "table-card",
              columns: _vm.latestTrackersColumns,
              nativeData: _vm.statistics.trackers,
              withPagination: false
            }
          })
        ],
        1
      )
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("header", { staticClass: "hero" }, [
      _c("div", { staticClass: "hero__intro" }, [
        _c("h1", [_vm._v("Dashboard")])
      ])
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/pages/DashboardPage.vue":
/*!**********************************************!*\
  !*** ./resources/js/pages/DashboardPage.vue ***!
  \**********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _DashboardPage_vue_vue_type_template_id_576da70a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./DashboardPage.vue?vue&type=template&id=576da70a& */ "./resources/js/pages/DashboardPage.vue?vue&type=template&id=576da70a&");
/* harmony import */ var _DashboardPage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./DashboardPage.vue?vue&type=script&lang=js& */ "./resources/js/pages/DashboardPage.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _DashboardPage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _DashboardPage_vue_vue_type_template_id_576da70a___WEBPACK_IMPORTED_MODULE_0__["render"],
  _DashboardPage_vue_vue_type_template_id_576da70a___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/DashboardPage.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/pages/DashboardPage.vue?vue&type=script&lang=js&":
/*!***********************************************************************!*\
  !*** ./resources/js/pages/DashboardPage.vue?vue&type=script&lang=js& ***!
  \***********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_DashboardPage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./DashboardPage.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/DashboardPage.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_DashboardPage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/DashboardPage.vue?vue&type=template&id=576da70a&":
/*!*****************************************************************************!*\
  !*** ./resources/js/pages/DashboardPage.vue?vue&type=template&id=576da70a& ***!
  \*****************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_DashboardPage_vue_vue_type_template_id_576da70a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./DashboardPage.vue?vue&type=template&id=576da70a& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/DashboardPage.vue?vue&type=template&id=576da70a&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_DashboardPage_vue_vue_type_template_id_576da70a___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_DashboardPage_vue_vue_type_template_id_576da70a___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);