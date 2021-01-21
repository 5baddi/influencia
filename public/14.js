(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[14],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/stories/all.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/stories/all.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************/
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

/* harmony default export */ __webpack_exports__["default"] = ({
  computed: _objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapGetters"])(["AuthenticatedUser", "stories"])), {}, {
    activeBrand: function activeBrand() {
      if (this.AuthenticatedUser !== null && typeof this.AuthenticatedUser !== "undefined" && this.AuthenticatedUser.selected_brand) return this.AuthenticatedUser.selected_brand;
      return null;
    }
  }),
  methods: {
    loadStories: function loadStories() {
      // Load stories
      if (Object.values(this.stories).length === 0) this.$store.dispatch("fetchStories")["catch"](function (error) {});
    },
    addStory: function addStory() {}
  },
  mounted: function mounted() {
    // Load stories
    if (typeof this.stories === "undefined" || this.stories === null || Object.values(this.stories).length === 0) this.loadStories();
  },
  data: function data() {
    return {
      attrActive: null
    };
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/stories/all.vue?vue&type=template&id=deeba6e8&":
/*!*********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/stories/all.vue?vue&type=template&id=deeba6e8& ***!
  \*********************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "listing" }, [
    _c("div", { staticClass: "hero" }, [
      _vm._m(0),
      _vm._v(" "),
      _vm.$can("create", "tracker") ||
      (_vm.AuthenticatedUser && _vm.AuthenticatedUser.is_superadmin)
        ? _c("div", { staticClass: "hero__actions" }, [
            _c(
              "button",
              {
                staticClass: "btn btn-success",
                attrs: { disabled: !_vm.activeBrand },
                on: {
                  click: function($event) {
                    return _vm.addStory()
                  }
                }
              },
              [_vm._v("Add new story")]
            )
          ])
        : _vm._e()
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "p-1 influencer" }, [
      _c(
        "div",
        { staticClass: "influencer-posts" },
        _vm._l(_vm.stories, function(story) {
          return _c(
            "a",
            {
              key: story.uuid,
              staticClass: "influencer-posts-card",
              attrs: { href: story.link || "#", target: "_blank" },
              on: {
                mouseover: function($event) {
                  _vm.attrActive = story.uuid
                },
                mouseleave: function($event) {
                  _vm.attrActive = null
                }
              }
            },
            [
              _c("img", { attrs: { src: story.thumbnail, loading: "lazy" } }),
              _vm._v(" "),
              story.type === "video"
                ? _c("i", {
                    class:
                      "influencer-posts-card-type fas fa-" +
                      (story.type === "image" ? "images" : "video")
                  })
                : _vm._e(),
              _vm._v(" "),
              _c("div", {
                class:
                  "influencer-posts-card-attr " +
                  (_vm.attrActive === story.uuid ? " active" : "")
              })
            ]
          )
        }),
        0
      )
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "hero__intro" }, [
      _c("h1", [_vm._v("Stories")]),
      _vm._v(" "),
      _c("ul", { staticClass: "breadcrumbs" }, [
        _c("li", [_c("a", { attrs: { href: "#" } }, [_vm._v("Dashboard")])]),
        _vm._v(" "),
        _c("li", [_c("a", { attrs: { href: "#" } }, [_vm._v("Stories")])])
      ])
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/pages/stories/all.vue":
/*!********************************************!*\
  !*** ./resources/js/pages/stories/all.vue ***!
  \********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _all_vue_vue_type_template_id_deeba6e8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./all.vue?vue&type=template&id=deeba6e8& */ "./resources/js/pages/stories/all.vue?vue&type=template&id=deeba6e8&");
/* harmony import */ var _all_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./all.vue?vue&type=script&lang=js& */ "./resources/js/pages/stories/all.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _all_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _all_vue_vue_type_template_id_deeba6e8___WEBPACK_IMPORTED_MODULE_0__["render"],
  _all_vue_vue_type_template_id_deeba6e8___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/stories/all.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/pages/stories/all.vue?vue&type=script&lang=js&":
/*!*********************************************************************!*\
  !*** ./resources/js/pages/stories/all.vue?vue&type=script&lang=js& ***!
  \*********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_all_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./all.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/stories/all.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_all_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/stories/all.vue?vue&type=template&id=deeba6e8&":
/*!***************************************************************************!*\
  !*** ./resources/js/pages/stories/all.vue?vue&type=template&id=deeba6e8& ***!
  \***************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_all_vue_vue_type_template_id_deeba6e8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./all.vue?vue&type=template&id=deeba6e8& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/stories/all.vue?vue&type=template&id=deeba6e8&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_all_vue_vue_type_template_id_deeba6e8___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_all_vue_vue_type_template_id_deeba6e8___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);