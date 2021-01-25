(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[19],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/modals/CreateBrandModal.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/modals/CreateBrandModal.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _FileInput__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../FileInput */ "./resources/js/components/FileInput.vue");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
    FileInput: _FileInput__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  data: function data() {
    return {
      show: false,
      brand: {
        uuid: null,
        name: null,
        image: null
      },
      title: "Add new brand"
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
    handleImageUpload: function handleImageUpload(files) {
      if (typeof files[0] === "undefined") return;
      this.brand.image = files[0];
    },
    open: function open(brand) {
      // $('html, body').animate({scrollTop:0}, '300');
      // // Init main container
      // let main = document.getElementById('content');
      // if(main !== null && main.style !== "undefined")
      //     main.style.overflowY = 'hidden';
      // this.$refs.modal.style.height = (window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight) + 'px';
      if (typeof brand !== "undefined") this.brand = brand;
      if (typeof brand !== "undefined" && typeof brand.uuid == "string" && brand.name !== null) this.title = "Update " + brand.name.slice();
      this.show = true;
    },
    close: function close() {
      // Init main container
      var main = document.getElementById('content');
      if (main !== null && main.style !== "undefined") main.style.overflowY = 'initial';
      this.show = false;
      this.brand = {
        uuid: null,
        name: null,
        image: null
      };
      this.title = "Add new brand";
    },
    submit: function submit() {
      var action = typeof this.brand.uuid === "undefined" || this.brand.uuid === null ? "create" : "update"; // Set base brand info

      var formData = new FormData();
      if (action === "update") formData.append("id", this.brand.id);
      formData.append("name", this.brand.name);
      if (typeof this.brand.image !== "undefined") formData.append("logo", this.brand.image);
      if (this.brand.uuid !== null) formData.append("uuid", this.brand.uuid);
      this.$emit(action, formData);
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/BrandsPage.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/BrandsPage.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _components_modals_CreateBrandModal__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../components/modals/CreateBrandModal */ "./resources/js/components/modals/CreateBrandModal.vue");
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_2__);
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



/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    CreateBrandModal: _components_modals_CreateBrandModal__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  notifications: {
    showError: {
      type: "error",
      title: "Error",
      message: "Something going wrong! Please try again.."
    },
    showSuccess: {
      type: "success"
    }
  },
  computed: _objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapGetters"])(["brands", "AuthenticatedUser"])),
  methods: {
    loadBrands: function loadBrands() {
      this.$store.dispatch("fetchBrands")["catch"](function (error) {});
    },
    addBrand: function addBrand() {
      this.$refs.brandFormModal.open();
    },
    editBrand: function editBrand(brand) {
      this.$refs.brandFormModal.open(Object.assign({}, brand));
    },
    deleteBrand: function deleteBrand(brand) {
      this.$refs.confirmDeleteBrandModal.open("Are sure to delete this brand?", brand);
    },
    deleteBrandAction: function deleteBrandAction(brand) {
      var _this = this;

      if (typeof brand.uuid === "undefined") this.showError();
      this.$store.dispatch("deleteBrand", brand.uuid).then(function (response) {
        // Reload datatable
        _this.$refs.brandsDT.reloadData(); // Show success notification


        _this.showSuccess({
          message: "Successfully deleted brand '" + brand.name + "'"
        });
      })["catch"](function (error) {
        _this.showError({
          message: error.message
        });
      });
    },
    create: function create(brand) {
      var _this2 = this;

      this.$store.dispatch("addBrand", brand).then(function (response) {
        _this2.$refs.brandsDT.reloadData();

        _this2.$refs.brandFormModal.close();

        _this2.showSuccess({
          message: "Brand created successfully"
        });
      })["catch"](function (error) {
        var errors = Object.values(error.response.data.errors);

        if (_typeof(errors) === "object" && errors.length > 0) {
          errors.forEach(function (element) {
            _this2.showError({
              message: element
            });
          });
        } else {
          _this2.showError({
            message: error.response.data.message
          });
        }
      });
    },
    update: function update(brand) {
      var _this3 = this;

      this.$store.dispatch("updateBrand", brand).then(function (response) {
        _this3.$refs.brandsDT.reloadData();

        _this3.$refs.brandFormModal.close();

        _this3.showSuccess({
          message: response.message
        });
      })["catch"](function (error) {
        var errors = Object.values(error.response.data.errors);

        if (_typeof(errors) === "object" && errors.length > 0) {
          errors.forEach(function (element) {
            _this3.showError({
              message: element
            });
          });
        } else {
          _this3.showError({
            message: error.response.data.message
          });
        }
      });
    }
  },
  mounted: function mounted() {
    // Load brands
    if (typeof this.brands === "undefined" || this.brands === null || Object.values(this.brands).length === 0) this.loadBrands();
  },
  data: function data() {
    return {
      columns: [{
        field: "logo",
        isImage: true,
        isAvatar: true,
        sortable: false
      }, {
        name: "name",
        field: "name"
      }, {
        name: "Number of users",
        field: "users_count",
        isNbr: true
      }, {
        name: 'users',
        field: 'users',
        callback: function callback(row) {
          if (!row.users) return '-';
          var html = '';
          row.users.map(function (item, index) {
            // html += '<li>' + item.name.toUpperCase() + '</li>';
            html += '<span class="badge badge-success">' + item.name.toUpperCase() + '</span>';
          });
          return html;
        }
      }, {
        name: "Number of campaigns",
        field: "campaigns_count",
        isNbr: true
      }, {
        name: "Number of trackers",
        field: "trackers_count",
        isNbr: true
      }, {
        name: "Created at",
        field: "created_at",
        isTimeAgo: true
      }]
    };
  }
});

/***/ }),

/***/ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/BrandsPage.vue?vue&type=style&index=0&id=0f155978&scoped=true&lang=css&":
/*!***********************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/BrandsPage.vue?vue&type=style&index=0&id=0f155978&scoped=true&lang=css& ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "\ntd img[data-v-0f155978] {\r\n    max-width: 36px;\r\n    border-radius: 50%;\n}\r\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/BrandsPage.vue?vue&type=style&index=0&id=0f155978&scoped=true&lang=css&":
/*!***************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/BrandsPage.vue?vue&type=style&index=0&id=0f155978&scoped=true&lang=css& ***!
  \***************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../node_modules/css-loader??ref--6-1!../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../node_modules/postcss-loader/src??ref--6-2!../../../node_modules/vue-loader/lib??vue-loader-options!./BrandsPage.vue?vue&type=style&index=0&id=0f155978&scoped=true&lang=css& */ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/BrandsPage.vue?vue&type=style&index=0&id=0f155978&scoped=true&lang=css&");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/modals/CreateBrandModal.vue?vue&type=template&id=21a4eb30&":
/*!**************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/modals/CreateBrandModal.vue?vue&type=template&id=21a4eb30& ***!
  \**************************************************************************************************************************************************************************************************************************/
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
    { ref: "modal", staticClass: "modal", class: { "show-modal": _vm.show } },
    [
      _c("div", { staticClass: "modal-content" }, [
        _c("header", [
          _c("h4", { staticClass: "heading" }, [_vm._v(_vm._s(_vm.title))])
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "modal-form" }, [
          _c("div", { staticClass: "control" }, [
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.brand.name,
                  expression: "brand.name"
                }
              ],
              attrs: { type: "text", placeholder: "Brand name" },
              domProps: { value: _vm.brand.name },
              on: {
                input: function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.$set(_vm.brand, "name", $event.target.value)
                }
              }
            })
          ]),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "control" },
            [
              _c(
                "div",
                {
                  directives: [
                    {
                      name: "show",
                      rawName: "v-show",
                      value: _vm.brand.image === null && _vm.brand.logo,
                      expression: "brand.image === null && brand.logo"
                    }
                  ],
                  staticStyle: { width: "100%", "text-align": "center" }
                },
                [
                  _c("img", {
                    staticStyle: { width: "240px", height: "auto" },
                    attrs: { src: _vm.brand.logo }
                  })
                ]
              ),
              _vm._v(" "),
              _c("FileInput", {
                attrs: {
                  id: "image",
                  label: "Upload brand image",
                  accept: "image/*",
                  isImage: true,
                  icon: "fas fa-plus",
                  multiple: false
                },
                on: { custom: _vm.handleImageUpload }
              })
            ],
            1
          ),
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
                    typeof _vm.brand.uuid == "string" ? "Update" : "Create"
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
    ]
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/BrandsPage.vue?vue&type=template&id=0f155978&scoped=true&":
/*!********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/BrandsPage.vue?vue&type=template&id=0f155978&scoped=true& ***!
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
  return _c(
    "div",
    { staticClass: "brands" },
    [
      _c("div", { staticClass: "hero" }, [
        _c("div", { staticClass: "hero__intro" }, [
          _c("h1", [_vm._v("Brands")]),
          _vm._v(" "),
          _c("ul", { staticClass: "breadcrumbs" }, [
            _c(
              "li",
              [
                _c("router-link", { attrs: { to: { name: "dashboard" } } }, [
                  _vm._v("Dashboard")
                ])
              ],
              1
            ),
            _vm._v(" "),
            _vm._m(0)
          ])
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "hero__actions" }, [
          _c(
            "button",
            {
              staticClass: "btn btn-success",
              on: {
                click: function($event) {
                  return _vm.addBrand()
                }
              }
            },
            [_vm._v("Add new Brand")]
          )
        ])
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "p-1" }, [
        _c("header", { staticClass: "cards" }, [
          _c("div", { staticClass: "card" }, [
            _c("div", { staticClass: "number" }, [
              _vm._v(
                _vm._s(
                  _vm.brands && typeof _vm.brands.length !== "undefined"
                    ? _vm.brands.length
                    : 0
                )
              )
            ]),
            _vm._v(" "),
            _c("p", { staticClass: "description" }, [
              _vm._v("NUMBER OF BRANDS")
            ])
          ])
        ]),
        _vm._v(" "),
        _vm.$can("list", "brand") ||
        (_vm.AuthenticatedUser && _vm.AuthenticatedUser.is_superadmin)
          ? _c(
              "div",
              { staticClass: "datatable-scroll" },
              [
                _c(
                  "DataTable",
                  {
                    ref: "brandsDT",
                    attrs: {
                      nativeData: _vm.brands,
                      fetchMethod: "fetchBrands",
                      columns: _vm.columns,
                      cssClasses: "table-card"
                    },
                    scopedSlots: _vm._u(
                      [
                        {
                          key: "body-row",
                          fn: function(row) {
                            return _c("td", {}, [
                              _vm.$can("edit", "brand") ||
                              (_vm.AuthenticatedUser &&
                                _vm.AuthenticatedUser.is_superadmin)
                                ? _c(
                                    "button",
                                    {
                                      staticClass: "btn icon-link",
                                      attrs: { title: "Edit brand" },
                                      on: {
                                        click: function($event) {
                                          return _vm.editBrand(
                                            row.data.original
                                          )
                                        }
                                      }
                                    },
                                    [_c("i", { staticClass: "fas fa-pen" })]
                                  )
                                : _vm._e(),
                              _vm._v(" "),
                              (_vm.$can("delete", "brand") ||
                                (_vm.AuthenticatedUser &&
                                  _vm.AuthenticatedUser.is_superadmin)) &&
                              row.data.original.campaigns_count === 0 &&
                              row.data.original.trackers_count === 0
                                ? _c(
                                    "button",
                                    {
                                      staticClass: "btn icon-link",
                                      attrs: { title: "Delete brand" },
                                      on: {
                                        click: function($event) {
                                          return _vm.deleteBrand(
                                            row.data.original
                                          )
                                        }
                                      }
                                    },
                                    [
                                      _c("i", {
                                        staticClass: "far fa-trash-alt"
                                      })
                                    ]
                                  )
                                : _vm._e()
                            ])
                          }
                        }
                      ],
                      null,
                      false,
                      2765073846
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
            )
          : _vm._e()
      ]),
      _vm._v(" "),
      _c("CreateBrandModal", {
        ref: "brandFormModal",
        on: { create: _vm.create, update: _vm.update }
      }),
      _vm._v(" "),
      _c("ConfirmationModal", {
        ref: "confirmDeleteBrandModal",
        on: { custom: _vm.deleteBrandAction }
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
    return _c("li", [_c("a", { attrs: { href: "#" } }, [_vm._v("Brands")])])
  }
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/modals/CreateBrandModal.vue":
/*!*************************************************************!*\
  !*** ./resources/js/components/modals/CreateBrandModal.vue ***!
  \*************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _CreateBrandModal_vue_vue_type_template_id_21a4eb30___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./CreateBrandModal.vue?vue&type=template&id=21a4eb30& */ "./resources/js/components/modals/CreateBrandModal.vue?vue&type=template&id=21a4eb30&");
/* harmony import */ var _CreateBrandModal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./CreateBrandModal.vue?vue&type=script&lang=js& */ "./resources/js/components/modals/CreateBrandModal.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _CreateBrandModal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _CreateBrandModal_vue_vue_type_template_id_21a4eb30___WEBPACK_IMPORTED_MODULE_0__["render"],
  _CreateBrandModal_vue_vue_type_template_id_21a4eb30___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/modals/CreateBrandModal.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/modals/CreateBrandModal.vue?vue&type=script&lang=js&":
/*!**************************************************************************************!*\
  !*** ./resources/js/components/modals/CreateBrandModal.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateBrandModal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./CreateBrandModal.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/modals/CreateBrandModal.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateBrandModal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/modals/CreateBrandModal.vue?vue&type=template&id=21a4eb30&":
/*!********************************************************************************************!*\
  !*** ./resources/js/components/modals/CreateBrandModal.vue?vue&type=template&id=21a4eb30& ***!
  \********************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateBrandModal_vue_vue_type_template_id_21a4eb30___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./CreateBrandModal.vue?vue&type=template&id=21a4eb30& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/modals/CreateBrandModal.vue?vue&type=template&id=21a4eb30&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateBrandModal_vue_vue_type_template_id_21a4eb30___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateBrandModal_vue_vue_type_template_id_21a4eb30___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/pages/BrandsPage.vue":
/*!*******************************************!*\
  !*** ./resources/js/pages/BrandsPage.vue ***!
  \*******************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _BrandsPage_vue_vue_type_template_id_0f155978_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./BrandsPage.vue?vue&type=template&id=0f155978&scoped=true& */ "./resources/js/pages/BrandsPage.vue?vue&type=template&id=0f155978&scoped=true&");
/* harmony import */ var _BrandsPage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./BrandsPage.vue?vue&type=script&lang=js& */ "./resources/js/pages/BrandsPage.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _BrandsPage_vue_vue_type_style_index_0_id_0f155978_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./BrandsPage.vue?vue&type=style&index=0&id=0f155978&scoped=true&lang=css& */ "./resources/js/pages/BrandsPage.vue?vue&type=style&index=0&id=0f155978&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _BrandsPage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _BrandsPage_vue_vue_type_template_id_0f155978_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _BrandsPage_vue_vue_type_template_id_0f155978_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "0f155978",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/BrandsPage.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/pages/BrandsPage.vue?vue&type=script&lang=js&":
/*!********************************************************************!*\
  !*** ./resources/js/pages/BrandsPage.vue?vue&type=script&lang=js& ***!
  \********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_BrandsPage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./BrandsPage.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/BrandsPage.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_BrandsPage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/BrandsPage.vue?vue&type=style&index=0&id=0f155978&scoped=true&lang=css&":
/*!****************************************************************************************************!*\
  !*** ./resources/js/pages/BrandsPage.vue?vue&type=style&index=0&id=0f155978&scoped=true&lang=css& ***!
  \****************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_BrandsPage_vue_vue_type_style_index_0_id_0f155978_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/style-loader!../../../node_modules/css-loader??ref--6-1!../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../node_modules/postcss-loader/src??ref--6-2!../../../node_modules/vue-loader/lib??vue-loader-options!./BrandsPage.vue?vue&type=style&index=0&id=0f155978&scoped=true&lang=css& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/BrandsPage.vue?vue&type=style&index=0&id=0f155978&scoped=true&lang=css&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_BrandsPage_vue_vue_type_style_index_0_id_0f155978_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_BrandsPage_vue_vue_type_style_index_0_id_0f155978_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_BrandsPage_vue_vue_type_style_index_0_id_0f155978_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_BrandsPage_vue_vue_type_style_index_0_id_0f155978_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));


/***/ }),

/***/ "./resources/js/pages/BrandsPage.vue?vue&type=template&id=0f155978&scoped=true&":
/*!**************************************************************************************!*\
  !*** ./resources/js/pages/BrandsPage.vue?vue&type=template&id=0f155978&scoped=true& ***!
  \**************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_BrandsPage_vue_vue_type_template_id_0f155978_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./BrandsPage.vue?vue&type=template&id=0f155978&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/BrandsPage.vue?vue&type=template&id=0f155978&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_BrandsPage_vue_vue_type_template_id_0f155978_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_BrandsPage_vue_vue_type_template_id_0f155978_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);