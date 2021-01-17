(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[5],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/navigations/MainNav.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/navigations/MainNav.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************/
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
      navCurrentState: true
    };
  },
  props: {
    authenticatedUser: {
      type: [Object, undefined]
    }
  },
  computed: {
    currentRouteName: function currentRouteName() {
      return this.$route.name;
    },
    isNavOpen: function isNavOpen() {
      return this.navCurrentState;
    }
  },
  methods: {
    toggle: function toggle() {
      this.navCurrentState = !this.navCurrentState;

      if (this.navCurrentState === false) {
        document.body.classList.add("nav-collapsed");
        document.getElementById("main-sidebar").addEventListener("mouseenter", this.removeClass);
        document.getElementById("main-sidebar").addEventListener("mouseleave", this.addClass);
      } else {
        document.getElementById("main-sidebar").removeEventListener("mouseenter", this.removeClass);
        document.getElementById("main-sidebar").removeEventListener("mouseleave", this.addClass);
        document.body.classList.remove("nav-collapsed");
      }
    },
    addClass: function addClass() {
      document.body.classList.add("nav-collapsed");
    },
    removeClass: function removeClass() {
      document.body.classList.remove("nav-collapsed");
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/navigations/TopNavItem.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/navigations/TopNavItem.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
    isSwitch: {
      type: Boolean,
      "default": false
    },
    brands: {
      type: Array
    },
    activeBrand: {
      type: [Object, undefined]
    }
  },
  data: function data() {
    return {
      showDropdown: false
    };
  },
  watch: {
    showDropdown: function showDropdown(newValue, oldValue) {
      if (newValue && this.showDropdown) {
        document.body.addEventListener("click", this.hideDropdown);
      }

      if (!newValue) {
        document.body.removeEventListener("click", this.hideDropdown);
      }
    }
  },
  computed: {
    selectedBrand: function selectedBrand() {
      if (!this.activeBrand || typeof this.activeBrand === "undefined" || typeof this.activeBrand.name === "undefined") {
        return {
          name: null,
          logo: null
        };
      } else {
        return this.activeBrand;
      }
    }
  },
  methods: {
    switchBrand: function switchBrand(brand, index) {
      var _this = this;

      this.$store.dispatch("setActiveBrand", brand).then(function () {
        _this.showDropdown = false;
      })["catch"](function (error) {});
    },
    hideDropdown: function hideDropdown(e) {
      if (!e.target.closest(".dashboard__navigation--item")) {
        this.showDropdown = false;
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/partials/Loader.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/partials/Loader.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************/
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
/* harmony default export */ __webpack_exports__["default"] = ({
  name: "Loader",
  props: ["visible"]
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/DashboardContainer.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/DashboardContainer.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _components_navigations_MainNav__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../components/navigations/MainNav */ "./resources/js/components/navigations/MainNav.vue");
/* harmony import */ var _components_navigations_TopNavItem__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../components/navigations/TopNavItem */ "./resources/js/components/navigations/TopNavItem.vue");
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
/* harmony import */ var _components_partials_Loader__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../components/partials/Loader */ "./resources/js/components/partials/Loader.vue");
/* harmony import */ var _api_index__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../api/index */ "./resources/js/api/index.js");
/* harmony import */ var _services_ability__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../services/ability */ "./resources/js/services/ability.js");
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






/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    MainNav: _components_navigations_MainNav__WEBPACK_IMPORTED_MODULE_0__["default"],
    TopNavItem: _components_navigations_TopNavItem__WEBPACK_IMPORTED_MODULE_1__["default"],
    Loader: _components_partials_Loader__WEBPACK_IMPORTED_MODULE_3__["default"]
  },
  computed: _objectSpread(_objectSpread(_objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_2__["mapState"])("Loader", ["loading"])), Object(vuex__WEBPACK_IMPORTED_MODULE_2__["mapGetters"])(["AuthenticatedUser", "brands"])), {}, {
    activeBrand: function activeBrand() {
      if (this.AuthenticatedUser !== null && typeof this.AuthenticatedUser !== "undefined" && this.AuthenticatedUser.selected_brand) {
        return this.AuthenticatedUser.selected_brand;
      } else {
        return null;
      }
    }
  }),
  watch: {
    showDropdown: function showDropdown(newValue, oldValue) {
      if (newValue && this.showDropdown) {
        document.body.addEventListener("click", this.hideDropdown);
      }

      if (!newValue) {
        document.body.removeEventListener("click", this.hideDropdown);
      }
    }
  },
  notifications: {
    showSuccessLogout: {
      type: "success",
      message: "Bye!"
    }
  },
  methods: {
    loadBrands: function loadBrands() {
      // Fetch brands
      this.$store.dispatch("fetchBrands")["catch"](function (error) {});
    },
    hideDropdown: function hideDropdown(e) {
      if (!e.target.closest(".dashboard__navigation--item")) {
        this.showDropdown = false;
      }
    },
    logout: function logout() {
      var _this = this;

      this.$store.dispatch("logout")["finally"](function () {
        _this.showSuccessLogout();

        _this.$router.push({
          name: "login"
        })["catch"](function () {});
      });
    }
  },
  beforeRouteEnter: function beforeRouteEnter(to, from, next) {
    next(function (vm) {
      var loggedIn = vm.$store.getters.isLogged;

      if (!loggedIn) {
        next({
          name: 'login'
        });
      } else {
        _api_index__WEBPACK_IMPORTED_MODULE_4__["api"].get("/api/abilities").then(function (response) {
          if (typeof response.data.content !== 'undefined') {
            _services_ability__WEBPACK_IMPORTED_MODULE_5__["default"].update(response.data.content);
          }
        })["catch"](function (error) {});
      }
    });
  },
  mounted: function mounted() {
    // Load brands
    if (typeof this.brands === "undefined" || this.brands === null || Object.values(this.brands).length === 0) this.loadBrands();
  },
  data: function data() {
    return {
      showDropdown: false
    };
  }
});

/***/ }),

/***/ "./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/partials/Loader.vue?vue&type=style&index=0&lang=scss&":
/*!*************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--7-2!./node_modules/sass-loader/dist/cjs.js??ref--7-3!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/partials/Loader.vue?vue&type=style&index=0&lang=scss& ***!
  \*************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, ".loader {\n  background: white;\n  transition: 0.15s ease-in opacity;\n  position: absolute;\n  top: 0;\n  left: 0;\n  right: 0;\n  bottom: 0;\n  pointer-events: none;\n  display: flex;\n  align-items: center;\n  justify-content: center;\n  font-size: 62pt;\n  color: #039be5;\n  overflow: hidden;\n  z-index: 100000000;\n}\n.loader--hidden {\n  display: none;\n  pointer-events: all;\n}", ""]);

// exports


/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/partials/Loader.vue?vue&type=style&index=0&lang=scss&":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--7-2!./node_modules/sass-loader/dist/cjs.js??ref--7-3!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/partials/Loader.vue?vue&type=style&index=0&lang=scss& ***!
  \*****************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../../node_modules/css-loader!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--7-2!../../../../node_modules/sass-loader/dist/cjs.js??ref--7-3!../../../../node_modules/vue-loader/lib??vue-loader-options!./Loader.vue?vue&type=style&index=0&lang=scss& */ "./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/partials/Loader.vue?vue&type=style&index=0&lang=scss&");

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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/navigations/MainNav.vue?vue&type=template&id=8a73a742&":
/*!**********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/navigations/MainNav.vue?vue&type=template&id=8a73a742& ***!
  \**********************************************************************************************************************************************************************************************************************/
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
    "aside",
    { staticClass: "dashboard__sidebar", attrs: { id: "main-sidebar" } },
    [
      _c("header", [
        _c("div", { staticClass: "dashboard__sidebar--content" }, [
          _c(
            "div",
            { staticClass: "logo" },
            [
              _c("router-link", { attrs: { to: { name: "dashboard" } } }, [
                _c("img", {
                  directives: [
                    {
                      name: "show",
                      rawName: "v-show",
                      value: _vm.isNavOpen,
                      expression: "isNavOpen"
                    }
                  ],
                  attrs: {
                    src: __webpack_require__(/*! @assets/img/log-inf.png */ "./resources/assets/img/log-inf.png"),
                    alt: "logo"
                  }
                }),
                _vm._v(" "),
                _c("img", {
                  directives: [
                    {
                      name: "show",
                      rawName: "v-show",
                      value: !_vm.isNavOpen,
                      expression: "!isNavOpen"
                    }
                  ],
                  attrs: {
                    src: __webpack_require__(/*! @assets/img/log-inf-mini.png */ "./resources/assets/img/log-inf-mini.png"),
                    alt: "logo"
                  }
                })
              ])
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c(
          "button",
          {
            staticClass: "dashboard__sidebar--toggle btn",
            on: { click: _vm.toggle }
          },
          [_c("span"), _vm._v(" "), _c("span"), _vm._v(" "), _c("span")]
        )
      ]),
      _vm._v(" "),
      _c("nav", { staticClass: "dashboard__sidebar__navigation" }, [
        _c("ul", [
          _c(
            "li",
            { class: { active: _vm.currentRouteName == "dashboard" } },
            [
              _c("router-link", { attrs: { to: { name: "dashboard" } } }, [
                _c("span", { staticClass: "icon" }, [
                  _c("i", { staticClass: "fas fa-columns" })
                ]),
                _vm._v(" "),
                _c("span", { staticClass: "text" }, [_vm._v("Dashboard")])
              ])
            ],
            1
          ),
          _vm._v(" "),
          _vm.$can("search", "scraper") ||
          (_vm.authenticatedUser && _vm.authenticatedUser.is_superadmin)
            ? _c(
                "li",
                { class: { active: _vm.currentRouteName == "search" } },
                [
                  _c("router-link", { attrs: { to: { name: "search" } } }, [
                    _c("span", { staticClass: "icon" }, [
                      _c("i", { staticClass: "fas fa-search" })
                    ]),
                    _vm._v(" "),
                    _c("span", { staticClass: "text" }, [_vm._v("Search")])
                  ])
                ],
                1
              )
            : _vm._e(),
          _vm._v(" "),
          _vm.$can("list", "campaign") ||
          (_vm.authenticatedUser && _vm.authenticatedUser.is_superadmin)
            ? _c(
                "li",
                { class: { active: _vm.currentRouteName == "campaigns" } },
                [
                  _c("router-link", { attrs: { to: { name: "campaigns" } } }, [
                    _c("span", { staticClass: "icon" }, [
                      _c("i", { staticClass: "fas fa-chart-pie" })
                    ]),
                    _vm._v(" "),
                    _c("span", { staticClass: "text" }, [_vm._v("Campaigns")])
                  ])
                ],
                1
              )
            : _vm._e(),
          _vm._v(" "),
          _vm.$can("list", "tracker") ||
          (_vm.authenticatedUser && _vm.authenticatedUser.is_superadmin)
            ? _c(
                "li",
                { class: { active: _vm.currentRouteName == "trackers" } },
                [
                  _c("router-link", { attrs: { to: { name: "trackers" } } }, [
                    _c("span", { staticClass: "icon" }, [
                      _c("i", { staticClass: "fas fa-code-branch" })
                    ]),
                    _vm._v(" "),
                    _c("span", { staticClass: "text" }, [_vm._v("Trackers")])
                  ])
                ],
                1
              )
            : _vm._e(),
          _vm._v(" "),
          _vm.$can("list", "influencer") ||
          (_vm.authenticatedUser && _vm.authenticatedUser.is_superadmin)
            ? _c(
                "li",
                { class: { active: _vm.currentRouteName == "influencers" } },
                [
                  _c(
                    "router-link",
                    { attrs: { to: { name: "influencers" } } },
                    [
                      _c("div", { staticClass: "icon" }, [
                        _c("i", { staticClass: "fas fa-podcast" })
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "text" }, [
                        _vm._v("Influencers")
                      ])
                    ]
                  )
                ],
                1
              )
            : _vm._e(),
          _vm._v(" "),
          _vm.$can("list", "brand") ||
          (_vm.authenticatedUser && _vm.authenticatedUser.is_superadmin)
            ? _c(
                "li",
                { class: { active: _vm.currentRouteName == "brands" } },
                [
                  _c("router-link", { attrs: { to: { name: "brands" } } }, [
                    _c("div", { staticClass: "icon" }, [
                      _c("i", { staticClass: "fas fa-copyright" })
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "text" }, [_vm._v("Brands")])
                  ])
                ],
                1
              )
            : _vm._e(),
          _vm._v(" "),
          _vm.$can("list", "user") ||
          (_vm.authenticatedUser && _vm.authenticatedUser.is_superadmin)
            ? _c(
                "li",
                { class: { active: _vm.currentRouteName == "users" } },
                [
                  _c("router-link", { attrs: { to: { name: "users" } } }, [
                    _c("div", { staticClass: "icon" }, [
                      _c("i", { staticClass: "fas fa-users" })
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "text" }, [_vm._v("Users")])
                  ])
                ],
                1
              )
            : _vm._e()
        ])
      ])
    ]
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/navigations/TopNavItem.vue?vue&type=template&id=4f0b0a9c&":
/*!*************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/navigations/TopNavItem.vue?vue&type=template&id=4f0b0a9c& ***!
  \*************************************************************************************************************************************************************************************************************************/
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
    { staticClass: "dashboard__navigation--item" },
    [
      !_vm.isSwitch
        ? [
            _c(
              "button",
              {
                staticClass: "btn",
                on: {
                  click: function($event) {
                    _vm.showDropdown = !_vm.showDropdown
                  }
                }
              },
              [_vm._t("button")],
              2
            ),
            _vm._v(" "),
            _vm.showDropdown
              ? _c("div", { staticClass: "dropdown" }, [_vm._t("dropdown")], 2)
              : _vm._e()
          ]
        : [
            _vm.selectedBrand && _vm.selectedBrand.name !== null
              ? _c(
                  "button",
                  {
                    staticClass: "btn",
                    on: {
                      click: function($event) {
                        _vm.showDropdown = !_vm.showDropdown
                      }
                    }
                  },
                  [
                    _c("div", { staticClass: "avatar" }, [
                      _c("img", {
                        attrs: { src: _vm.selectedBrand.logo, alt: "" }
                      })
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "text" }, [
                      _c("p", [_vm._v(_vm._s(_vm.selectedBrand.name))]),
                      _vm._v(" "),
                      _c("div", { staticClass: "icon" }, [
                        _c(
                          "svg",
                          {
                            staticClass: "sc-fzqAbL fPXfOL",
                            attrs: {
                              width: "24",
                              height: "24",
                              viewBox: "0 0 24 24",
                              color: "#000629"
                            }
                          },
                          [
                            _c(
                              "g",
                              {
                                attrs: { fill: "none", "fill-rule": "evenodd" }
                              },
                              [
                                _c("circle", {
                                  attrs: { cx: "12", cy: "12", r: "12" }
                                }),
                                _vm._v(" "),
                                _c("path", {
                                  attrs: {
                                    fill: "#000",
                                    d:
                                      "M12.492 12.283L7.306 7 5 9.35 12.492 17 20 9.35 17.677 7z"
                                  }
                                })
                              ]
                            )
                          ]
                        )
                      ])
                    ])
                  ]
                )
              : _vm._e(),
            _vm._v(" "),
            _vm.showDropdown
              ? _c("div", { staticClass: "dropdown" }, [
                  _vm.brands && _vm.brands.length > 0
                    ? _c(
                        "ul",
                        _vm._l(_vm.brands, function(brand, index) {
                          return _c("li", { key: brand.id }, [
                            _c(
                              "a",
                              {
                                on: {
                                  click: function($event) {
                                    $event.preventDefault()
                                    return _vm.switchBrand(brand, index)
                                  }
                                }
                              },
                              [
                                _c("div", { staticClass: "icon" }, [
                                  _c("img", { attrs: { src: brand.logo } })
                                ]),
                                _vm._v(" "),
                                _c("div", { staticClass: "text" }, [
                                  _vm._v(_vm._s(brand.name))
                                ])
                              ]
                            )
                          ])
                        }),
                        0
                      )
                    : _vm._e()
                ])
              : _vm._e()
          ]
    ],
    2
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/partials/Loader.vue?vue&type=template&id=5eeaba55&":
/*!******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/partials/Loader.vue?vue&type=template&id=5eeaba55& ***!
  \******************************************************************************************************************************************************************************************************************/
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
    { staticClass: "loader", class: { "loader--hidden": !_vm.visible } },
    [_c("i", { staticClass: "fas fa-spinner fa-spin" })]
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/DashboardContainer.vue?vue&type=template&id=501469d4&":
/*!****************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/DashboardContainer.vue?vue&type=template&id=501469d4& ***!
  \****************************************************************************************************************************************************************************************************************/
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
    "main",
    { staticClass: "dashboard", attrs: { id: "main" } },
    [
      _c("MainNav", { attrs: { authenticatedUser: _vm.AuthenticatedUser } }),
      _vm._v(" "),
      _c(
        "div",
        {
          ref: "content",
          staticClass: "dashboard__content",
          attrs: { id: "content" }
        },
        [
          _c(
            "div",
            { staticClass: "dashboard__navigation" },
            [
              _c("TopNavItem", {
                staticClass: "nav-switch",
                attrs: {
                  brands: _vm.brands,
                  activeBrand: _vm.activeBrand,
                  isSwitch: true
                }
              }),
              _vm._v(" "),
              _c("TopNavItem", {
                attrs: { isSwitch: false },
                scopedSlots: _vm._u(
                  [
                    _vm.AuthenticatedUser
                      ? {
                          key: "button",
                          fn: function() {
                            return [
                              _c("div", { staticClass: "avatar" }, [
                                _c("img", {
                                  attrs: {
                                    src:
                                      "https://ui-avatars.com/api/?color=039be5&name=" +
                                      _vm.AuthenticatedUser.name
                                  }
                                })
                              ]),
                              _vm._v(" "),
                              _c("div", { staticClass: "text" }, [
                                _c("p", [
                                  _vm._v(_vm._s(_vm.AuthenticatedUser.name))
                                ]),
                                _vm._v(" "),
                                _c("div", { staticClass: "icon" }, [
                                  _c(
                                    "svg",
                                    {
                                      staticClass: "sc-fzqAbL fPXfOL",
                                      attrs: {
                                        width: "24",
                                        height: "24",
                                        viewBox: "0 0 24 24",
                                        color: "#000629"
                                      }
                                    },
                                    [
                                      _c(
                                        "g",
                                        {
                                          attrs: {
                                            fill: "none",
                                            "fill-rule": "evenodd"
                                          }
                                        },
                                        [
                                          _c("circle", {
                                            attrs: {
                                              cx: "12",
                                              cy: "12",
                                              r: "12"
                                            }
                                          }),
                                          _vm._v(" "),
                                          _c("path", {
                                            attrs: {
                                              fill: "#000",
                                              d:
                                                "M12.492 12.283L7.306 7 5 9.35 12.492 17 20 9.35 17.677 7z"
                                            }
                                          })
                                        ]
                                      )
                                    ]
                                  )
                                ])
                              ])
                            ]
                          },
                          proxy: true
                        }
                      : null,
                    {
                      key: "dropdown",
                      fn: function() {
                        return [
                          _c("ul", [
                            _vm.$can("edit-info", "user") ||
                            (_vm.AuthenticatedUser &&
                              _vm.AuthenticatedUser.is_superadmin)
                              ? _c(
                                  "li",
                                  [
                                    _c(
                                      "router-link",
                                      { attrs: { to: { name: "settings" } } },
                                      [
                                        _c("div", { staticClass: "icon" }, [
                                          _c("i", {
                                            staticClass: "fas fa-user-cog"
                                          })
                                        ]),
                                        _vm._v(" "),
                                        _c("div", { staticClass: "text" }, [
                                          _vm._v("Settings")
                                        ])
                                      ]
                                    )
                                  ],
                                  1
                                )
                              : _vm._e(),
                            _vm._v(" "),
                            _c("li", [
                              _c(
                                "a",
                                {
                                  attrs: { href: "javascript:void(0);" },
                                  on: { click: _vm.logout }
                                },
                                [
                                  _c("div", { staticClass: "icon" }, [
                                    _c("i", { staticClass: "fas fa-lock" })
                                  ]),
                                  _vm._v(" "),
                                  _c("div", { staticClass: "text" }, [
                                    _vm._v("Logout")
                                  ])
                                ]
                              )
                            ])
                          ])
                        ]
                      },
                      proxy: true
                    }
                  ],
                  null,
                  true
                )
              })
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "dashboard__content__page" },
            [
              _c("Loader", { attrs: { visible: _vm.loading } }),
              _vm._v(" "),
              _c("router-view")
            ],
            1
          )
        ]
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/assets/img/log-inf-mini.png":
/*!***********************************************!*\
  !*** ./resources/assets/img/log-inf-mini.png ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "/images/log-inf-mini.png?cb0e0db2e4056db3b4e2923ed7a1fd31";

/***/ }),

/***/ "./resources/assets/img/log-inf.png":
/*!******************************************!*\
  !*** ./resources/assets/img/log-inf.png ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "/images/log-inf.png?736bb81d7e0cf6f7c8b429b67103b625";

/***/ }),

/***/ "./resources/js/components/navigations/MainNav.vue":
/*!*********************************************************!*\
  !*** ./resources/js/components/navigations/MainNav.vue ***!
  \*********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _MainNav_vue_vue_type_template_id_8a73a742___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./MainNav.vue?vue&type=template&id=8a73a742& */ "./resources/js/components/navigations/MainNav.vue?vue&type=template&id=8a73a742&");
/* harmony import */ var _MainNav_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./MainNav.vue?vue&type=script&lang=js& */ "./resources/js/components/navigations/MainNav.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _MainNav_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _MainNav_vue_vue_type_template_id_8a73a742___WEBPACK_IMPORTED_MODULE_0__["render"],
  _MainNav_vue_vue_type_template_id_8a73a742___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/navigations/MainNav.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/navigations/MainNav.vue?vue&type=script&lang=js&":
/*!**********************************************************************************!*\
  !*** ./resources/js/components/navigations/MainNav.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_MainNav_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./MainNav.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/navigations/MainNav.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_MainNav_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/navigations/MainNav.vue?vue&type=template&id=8a73a742&":
/*!****************************************************************************************!*\
  !*** ./resources/js/components/navigations/MainNav.vue?vue&type=template&id=8a73a742& ***!
  \****************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_MainNav_vue_vue_type_template_id_8a73a742___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./MainNav.vue?vue&type=template&id=8a73a742& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/navigations/MainNav.vue?vue&type=template&id=8a73a742&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_MainNav_vue_vue_type_template_id_8a73a742___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_MainNav_vue_vue_type_template_id_8a73a742___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/navigations/TopNavItem.vue":
/*!************************************************************!*\
  !*** ./resources/js/components/navigations/TopNavItem.vue ***!
  \************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _TopNavItem_vue_vue_type_template_id_4f0b0a9c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TopNavItem.vue?vue&type=template&id=4f0b0a9c& */ "./resources/js/components/navigations/TopNavItem.vue?vue&type=template&id=4f0b0a9c&");
/* harmony import */ var _TopNavItem_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TopNavItem.vue?vue&type=script&lang=js& */ "./resources/js/components/navigations/TopNavItem.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _TopNavItem_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _TopNavItem_vue_vue_type_template_id_4f0b0a9c___WEBPACK_IMPORTED_MODULE_0__["render"],
  _TopNavItem_vue_vue_type_template_id_4f0b0a9c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/navigations/TopNavItem.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/navigations/TopNavItem.vue?vue&type=script&lang=js&":
/*!*************************************************************************************!*\
  !*** ./resources/js/components/navigations/TopNavItem.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TopNavItem_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./TopNavItem.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/navigations/TopNavItem.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TopNavItem_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/navigations/TopNavItem.vue?vue&type=template&id=4f0b0a9c&":
/*!*******************************************************************************************!*\
  !*** ./resources/js/components/navigations/TopNavItem.vue?vue&type=template&id=4f0b0a9c& ***!
  \*******************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TopNavItem_vue_vue_type_template_id_4f0b0a9c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./TopNavItem.vue?vue&type=template&id=4f0b0a9c& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/navigations/TopNavItem.vue?vue&type=template&id=4f0b0a9c&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TopNavItem_vue_vue_type_template_id_4f0b0a9c___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TopNavItem_vue_vue_type_template_id_4f0b0a9c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/partials/Loader.vue":
/*!*****************************************************!*\
  !*** ./resources/js/components/partials/Loader.vue ***!
  \*****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Loader_vue_vue_type_template_id_5eeaba55___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Loader.vue?vue&type=template&id=5eeaba55& */ "./resources/js/components/partials/Loader.vue?vue&type=template&id=5eeaba55&");
/* harmony import */ var _Loader_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Loader.vue?vue&type=script&lang=js& */ "./resources/js/components/partials/Loader.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _Loader_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Loader.vue?vue&type=style&index=0&lang=scss& */ "./resources/js/components/partials/Loader.vue?vue&type=style&index=0&lang=scss&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _Loader_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Loader_vue_vue_type_template_id_5eeaba55___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Loader_vue_vue_type_template_id_5eeaba55___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/partials/Loader.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/partials/Loader.vue?vue&type=script&lang=js&":
/*!******************************************************************************!*\
  !*** ./resources/js/components/partials/Loader.vue?vue&type=script&lang=js& ***!
  \******************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Loader_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Loader.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/partials/Loader.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Loader_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/partials/Loader.vue?vue&type=style&index=0&lang=scss&":
/*!***************************************************************************************!*\
  !*** ./resources/js/components/partials/Loader.vue?vue&type=style&index=0&lang=scss& ***!
  \***************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Loader_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/style-loader!../../../../node_modules/css-loader!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--7-2!../../../../node_modules/sass-loader/dist/cjs.js??ref--7-3!../../../../node_modules/vue-loader/lib??vue-loader-options!./Loader.vue?vue&type=style&index=0&lang=scss& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/partials/Loader.vue?vue&type=style&index=0&lang=scss&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Loader_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Loader_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Loader_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Loader_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));


/***/ }),

/***/ "./resources/js/components/partials/Loader.vue?vue&type=template&id=5eeaba55&":
/*!************************************************************************************!*\
  !*** ./resources/js/components/partials/Loader.vue?vue&type=template&id=5eeaba55& ***!
  \************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Loader_vue_vue_type_template_id_5eeaba55___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./Loader.vue?vue&type=template&id=5eeaba55& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/partials/Loader.vue?vue&type=template&id=5eeaba55&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Loader_vue_vue_type_template_id_5eeaba55___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Loader_vue_vue_type_template_id_5eeaba55___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/pages/DashboardContainer.vue":
/*!***************************************************!*\
  !*** ./resources/js/pages/DashboardContainer.vue ***!
  \***************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _DashboardContainer_vue_vue_type_template_id_501469d4___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./DashboardContainer.vue?vue&type=template&id=501469d4& */ "./resources/js/pages/DashboardContainer.vue?vue&type=template&id=501469d4&");
/* harmony import */ var _DashboardContainer_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./DashboardContainer.vue?vue&type=script&lang=js& */ "./resources/js/pages/DashboardContainer.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _DashboardContainer_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _DashboardContainer_vue_vue_type_template_id_501469d4___WEBPACK_IMPORTED_MODULE_0__["render"],
  _DashboardContainer_vue_vue_type_template_id_501469d4___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/DashboardContainer.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/pages/DashboardContainer.vue?vue&type=script&lang=js&":
/*!****************************************************************************!*\
  !*** ./resources/js/pages/DashboardContainer.vue?vue&type=script&lang=js& ***!
  \****************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_DashboardContainer_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./DashboardContainer.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/DashboardContainer.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_DashboardContainer_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/DashboardContainer.vue?vue&type=template&id=501469d4&":
/*!**********************************************************************************!*\
  !*** ./resources/js/pages/DashboardContainer.vue?vue&type=template&id=501469d4& ***!
  \**********************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_DashboardContainer_vue_vue_type_template_id_501469d4___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./DashboardContainer.vue?vue&type=template&id=501469d4& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/DashboardContainer.vue?vue&type=template&id=501469d4&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_DashboardContainer_vue_vue_type_template_id_501469d4___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_DashboardContainer_vue_vue_type_template_id_501469d4___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);