(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[19],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/FileInput.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/FileInput.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************/
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
/* harmony default export */ __webpack_exports__["default"] = ({
  props: {
    id: {
      type: String,
      "default": "Upload-file"
    },
    label: {
      type: String,
      "default": "Upload file"
    },
    accept: {
      type: String,
      "default": "*"
    },
    multiple: {
      type: Boolean,
      "default": false
    },
    isList: {
      type: Boolean,
      "default": false
    },
    isImage: {
      type: Boolean,
      "default": false
    },
    icon: {
      type: String,
      "default": null
    }
  },
  methods: {
    preventFileInput: function preventFileInput() {
      var ref = this.$refs[this.id];

      if (ref !== 'undefined') {
        ref.click();
      }
    },
    fileChanged: function fileChanged() {
      var ref = this.$refs[this.id];
      if (!ref.files[0]) return; // Verify duplicate file then push the file

      var existsIndex = this.files.findIndex(function (i) {
        return i.name === ref.files[0].name;
      });

      if (existsIndex === -1) {
        if (this.multiple) {
          var vm = this;
          Array.from(ref.files).forEach(function (file) {
            vm.files.push(file);
          });
        } else {
          this.files = [ref.files[0]];
        } // Is image


        if (this.isImage) {
          var _vm = this;

          var reader = new FileReader();

          reader.onload = function (e) {
            _vm.$refs.img_src.src = e.target.result;
          };

          reader.readAsDataURL(ref.files[0]);
        }
      } // Emit on change method


      this.$emit("custom", this.files);
    },
    removeFile: function removeFile(index) {
      this.files.splice(index, 1);
    },
    removeImage: function removeImage() {
      this.files = [];
    }
  },
  data: function data() {
    return {
      files: [],
      imgSrc: null
    };
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/trackers/New.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/trackers/New.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
/* harmony import */ var _components_FileInput__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../components/FileInput */ "./resources/js/components/FileInput.vue");
/* harmony import */ var _johmun_vue_tags_input__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @johmun/vue-tags-input */ "./node_modules/@johmun/vue-tags-input/dist/vue-tags-input.js");
/* harmony import */ var _johmun_vue_tags_input__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_johmun_vue_tags_input__WEBPACK_IMPORTED_MODULE_2__);
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
    FileInput: _components_FileInput__WEBPACK_IMPORTED_MODULE_1__["default"],
    VueTagsInput: _johmun_vue_tags_input__WEBPACK_IMPORTED_MODULE_2___default.a
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
  computed: _objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapGetters"])(["AuthenticatedUser", "campaigns"])),
  data: function data() {
    return {
      user_id: null,
      campaign_id: null,
      platform: "instagram",
      name: null,
      type: "post",
      username: null,
      story: null,
      url: '',
      urls: [],
      reach: null,
      impressions: null,
      interactions: null,
      back: null,
      forward: null,
      next_story: null,
      exited: null,
      published_at: null
    };
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
      this.reach = null;
      this.impressions = null;
      this.interactions = null;
      this.back = null;
      this.forward = null;
      this.next_story = null;
      this.exited = null;
      this.published_at = null;
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
        _data.reach = this.reach;
        _data.impressions = this.impressions;
        _data.interactions = this.interactions;
        _data.back = this.back;
        _data.forward = this.forward;
        _data.next_story = this.next_story;
        _data.exited = this.exited;
        _data.published_at = this.published_at;
      } // Create new tracker


      this.create(_data);
    },
    create: function create(payload) {
      var _this = this;

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
        _this.init();

        _this.createTrackerSuccess({
          message: "Tracker ".concat(response.content.name, " created successfuly!")
        });

        _this.$router.push({
          name: 'trackers'
        });
      })["catch"](function (error) {
        var errors = Object.values(error.response.data.errors);

        if (_typeof(errors) === "object" && errors.length > 0) {
          errors.forEach(function (element) {
            _this.showError({
              message: element
            });
          });
        } else {
          _this.showError({
            message: error.response.data.message
          });
        }
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/FileInput.vue?vue&type=style&index=0&id=6c71a2d3&scoped=true&lang=css&":
/*!***************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/FileInput.vue?vue&type=style&index=0&id=6c71a2d3&scoped=true&lang=css& ***!
  \***************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "\n.custom-file-upload[data-v-6c71a2d3]{\n    width: 100%;\n    height: auto;\n    overflow: hidden;\n    margin: 1rem 0;\n}\n.custom-file-upload > input[type=file][data-v-6c71a2d3]{\n    display: none;\n}\n.custom-file-upload .btn[data-v-6c71a2d3]{\n    width: 100%;\n    color: white;\n    font-size: 8pt;\n}\n.custom-file-upload .btn-primary[data-v-6c71a2d3]{\n    background-color: #039be5;\n}\n.custom-file-upload .btn-flat[data-v-6c71a2d3]{\n    border: none;\n    background-color: unset;\n    cursor: pointer;\n}\n.custom-file-upload .btn-flat[data-v-6c71a2d3]:hover, .custom-file-upload .btn-flat[data-v-6c71a2d3]:focus{\n    opacity: .7;\n}\n.custom-file-upload .btn-flat-danger[data-v-6c71a2d3]{\n    color: #f44336;\n}\n.custom-file-upload ul li[data-v-6c71a2d3]{\n    font-size: 10pt;\n    font-weight: normal;\n    padding: 12px;\n}\n.custom-file-upload .btn[data-v-6c71a2d3]{\n    display: initial !important;\n}\n.custom-file-preview button[data-v-6c71a2d3]{\n    position: absolute;\n    top: 0;\n    right: 0;\n    transform: translate(-50%, 50%);\n}\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/FileInput.vue?vue&type=style&index=0&id=6c71a2d3&scoped=true&lang=css&":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/FileInput.vue?vue&type=style&index=0&id=6c71a2d3&scoped=true&lang=css& ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../node_modules/css-loader??ref--6-1!../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../node_modules/postcss-loader/src??ref--6-2!../../../node_modules/vue-loader/lib??vue-loader-options!./FileInput.vue?vue&type=style&index=0&id=6c71a2d3&scoped=true&lang=css& */ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/FileInput.vue?vue&type=style&index=0&id=6c71a2d3&scoped=true&lang=css&");

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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/FileInput.vue?vue&type=template&id=6c71a2d3&scoped=true&":
/*!************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/FileInput.vue?vue&type=template&id=6c71a2d3&scoped=true& ***!
  \************************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "custom-file-upload" }, [
    _c(
      "ul",
      {
        directives: [
          {
            name: "show",
            rawName: "v-show",
            value: _vm.isList,
            expression: "isList"
          }
        ]
      },
      _vm._l(_vm.files, function(file, index) {
        return _c("li", { key: file.name }, [
          _vm._v(
            _vm._s(
              file.name
                .split(".")
                .slice(0, -1)
                .join(".")
            ) + " "
          ),
          _c(
            "button",
            {
              staticClass: "btn-flat btn-flat-danger",
              attrs: { type: "button" },
              on: {
                click: function($event) {
                  return _vm.removeFile(index)
                }
              }
            },
            [_c("i", { staticClass: "fas fa-times" })]
          )
        ])
      }),
      0
    ),
    _vm._v(" "),
    _c(
      "div",
      {
        directives: [
          {
            name: "show",
            rawName: "v-show",
            value: _vm.isImage && _vm.files.length === 1,
            expression: "isImage && files.length === 1"
          }
        ],
        staticClass: "custom-file-preview"
      },
      [
        _c(
          "button",
          {
            staticClass: "btn-flat btn-flat-danger",
            attrs: { type: "button" },
            on: { click: _vm.removeImage }
          },
          [_c("i", { staticClass: "fas fa-times" })]
        ),
        _vm._v(" "),
        _c("img", { ref: "img_src" })
      ]
    ),
    _vm._v(" "),
    _c(
      "button",
      {
        staticClass: "btn btn-primary custom-file-input",
        attrs: { type: "button" },
        on: {
          click: function($event) {
            return _vm.preventFileInput()
          }
        }
      },
      [_c("i", { class: _vm.icon }), _vm._v(" " + _vm._s(_vm.label))]
    ),
    _vm._v(" "),
    _c("input", {
      ref: _vm.id,
      attrs: {
        id: _vm.id,
        type: "file",
        accept: _vm.accept,
        multiple: _vm.multiple
      },
      on: { change: _vm.fileChanged }
    })
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/trackers/New.vue?vue&type=template&id=530bb995&":
/*!**********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/trackers/New.vue?vue&type=template&id=530bb995& ***!
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
  return _c("div", { staticClass: "p-1" }, [
    _c("div", { staticClass: "card" }, [
      _vm._m(0),
      _vm._v(" "),
      _c("div", { staticClass: "card__content" }, [
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
                      attrs: { type: "radio", id: "story", value: "story" },
                      domProps: { checked: _vm._q(_vm.type, "story") },
                      on: {
                        change: function($event) {
                          _vm.type = "story"
                        }
                      }
                    }),
                    _vm._v(" "),
                    _c("span", [
                      _vm._v("Interactions for an Instagram or Snapchat story")
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
                        { attrs: { selected: "" }, domProps: { value: null } },
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
                            _vm.type === "url" ? "Destination URL" : "Post URL"
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
                      _c("label", [_vm._v("Story sequence")]),
                      _vm._v(" "),
                      _c("FileInput", {
                        attrs: {
                          id: "storyfile",
                          label: "Upload story sequence",
                          accept:
                            "image/jpeg,image/png,image/gif,video/mp4,video/quicktime",
                          isList: true,
                          icon: "fas fa-plus",
                          multiple: false
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
                  _c(
                    "div",
                    { staticClass: "control" },
                    [
                      _c("label", [_vm._v("Reach")]),
                      _vm._v(" "),
                      _c("vue-numeric", {
                        model: {
                          value: _vm.reach,
                          callback: function($$v) {
                            _vm.reach = $$v
                          },
                          expression: "reach"
                        }
                      }),
                      _vm._v(" "),
                      _c("p", [_vm._v("Accounts reached with this story.")])
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "control" },
                    [
                      _c("label", [_vm._v("Impressions")]),
                      _vm._v(" "),
                      _c("vue-numeric", {
                        model: {
                          value: _vm.impressions,
                          callback: function($$v) {
                            _vm.impressions = $$v
                          },
                          expression: "impressions"
                        }
                      }),
                      _vm._v(" "),
                      _c("p", [_vm._v("Number of impressions.")])
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "control" },
                    [
                      _c("label", [_vm._v("Interactions")]),
                      _vm._v(" "),
                      _c("vue-numeric", {
                        model: {
                          value: _vm.interactions,
                          callback: function($$v) {
                            _vm.interactions = $$v
                          },
                          expression: "interactions"
                        }
                      }),
                      _vm._v(" "),
                      _c("p", [_vm._v("Actions taken from this story.")])
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "control" },
                    [
                      _c("label", [_vm._v("Back")]),
                      _vm._v(" "),
                      _c("vue-numeric", {
                        model: {
                          value: _vm.back,
                          callback: function($$v) {
                            _vm.back = $$v
                          },
                          expression: "back"
                        }
                      }),
                      _vm._v(" "),
                      _c("p", [
                        _vm._v(
                          "Number of taps users made to see the previous photo or video in this story."
                        )
                      ])
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "control" },
                    [
                      _c("label", [_vm._v("Forward")]),
                      _vm._v(" "),
                      _c("vue-numeric", {
                        model: {
                          value: _vm.forward,
                          callback: function($$v) {
                            _vm.forward = $$v
                          },
                          expression: "forward"
                        }
                      }),
                      _vm._v(" "),
                      _c("p", [
                        _vm._v(
                          "Number of taps users made to see the next photo or video in this story."
                        )
                      ])
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "control" },
                    [
                      _c("label", [_vm._v("Next story")]),
                      _vm._v(" "),
                      _c("vue-numeric", {
                        model: {
                          value: _vm.next_story,
                          callback: function($$v) {
                            _vm.next_story = $$v
                          },
                          expression: "next_story"
                        }
                      }),
                      _vm._v(" "),
                      _c("p", [
                        _vm._v(
                          "Number of taps users made to see the next account's story."
                        )
                      ])
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "control" },
                    [
                      _c("label", [_vm._v("Exited")]),
                      _vm._v(" "),
                      _c("vue-numeric", {
                        model: {
                          value: _vm.exited,
                          callback: function($$v) {
                            _vm.exited = $$v
                          },
                          expression: "exited"
                        }
                      }),
                      _vm._v(" "),
                      _c("p", [
                        _vm._v(
                          "Number of times a user swiped away from this story."
                        )
                      ])
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "control" },
                    [
                      _c("label", [_vm._v("Published at")]),
                      _vm._v(" "),
                      _c("datetime", {
                        attrs: {
                          type: "datetime",
                          title: "Story publiction datetime",
                          "use12-hour": false
                        },
                        model: {
                          value: _vm.published_at,
                          callback: function($$v) {
                            _vm.published_at = $$v
                          },
                          expression: "published_at"
                        }
                      }),
                      _vm._v(" "),
                      _c("p", [_vm._v("Story publiction datetime.")])
                    ],
                    1
                  )
                ]
              )
            ]),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "modal-form__actions" },
              [
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
                  "router-link",
                  {
                    staticClass: "btn btn-danger",
                    attrs: { to: { name: "trackers" } }
                  },
                  [_vm._v("Cancel")]
                )
              ],
              1
            )
          ]
        )
      ])
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("header", [_c("h2", [_vm._v("Add new Tracker")])])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("span", [
      _c("i", { staticClass: "fab fa-instagram" }),
      _vm._v(" Instagram")
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/FileInput.vue":
/*!***********************************************!*\
  !*** ./resources/js/components/FileInput.vue ***!
  \***********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _FileInput_vue_vue_type_template_id_6c71a2d3_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./FileInput.vue?vue&type=template&id=6c71a2d3&scoped=true& */ "./resources/js/components/FileInput.vue?vue&type=template&id=6c71a2d3&scoped=true&");
/* harmony import */ var _FileInput_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./FileInput.vue?vue&type=script&lang=js& */ "./resources/js/components/FileInput.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _FileInput_vue_vue_type_style_index_0_id_6c71a2d3_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./FileInput.vue?vue&type=style&index=0&id=6c71a2d3&scoped=true&lang=css& */ "./resources/js/components/FileInput.vue?vue&type=style&index=0&id=6c71a2d3&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _FileInput_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _FileInput_vue_vue_type_template_id_6c71a2d3_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _FileInput_vue_vue_type_template_id_6c71a2d3_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "6c71a2d3",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/FileInput.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/FileInput.vue?vue&type=script&lang=js&":
/*!************************************************************************!*\
  !*** ./resources/js/components/FileInput.vue?vue&type=script&lang=js& ***!
  \************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_FileInput_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./FileInput.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/FileInput.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_FileInput_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/FileInput.vue?vue&type=style&index=0&id=6c71a2d3&scoped=true&lang=css&":
/*!********************************************************************************************************!*\
  !*** ./resources/js/components/FileInput.vue?vue&type=style&index=0&id=6c71a2d3&scoped=true&lang=css& ***!
  \********************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_FileInput_vue_vue_type_style_index_0_id_6c71a2d3_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/style-loader!../../../node_modules/css-loader??ref--6-1!../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../node_modules/postcss-loader/src??ref--6-2!../../../node_modules/vue-loader/lib??vue-loader-options!./FileInput.vue?vue&type=style&index=0&id=6c71a2d3&scoped=true&lang=css& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/FileInput.vue?vue&type=style&index=0&id=6c71a2d3&scoped=true&lang=css&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_FileInput_vue_vue_type_style_index_0_id_6c71a2d3_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_FileInput_vue_vue_type_style_index_0_id_6c71a2d3_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_FileInput_vue_vue_type_style_index_0_id_6c71a2d3_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_FileInput_vue_vue_type_style_index_0_id_6c71a2d3_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));


/***/ }),

/***/ "./resources/js/components/FileInput.vue?vue&type=template&id=6c71a2d3&scoped=true&":
/*!******************************************************************************************!*\
  !*** ./resources/js/components/FileInput.vue?vue&type=template&id=6c71a2d3&scoped=true& ***!
  \******************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_FileInput_vue_vue_type_template_id_6c71a2d3_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./FileInput.vue?vue&type=template&id=6c71a2d3&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/FileInput.vue?vue&type=template&id=6c71a2d3&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_FileInput_vue_vue_type_template_id_6c71a2d3_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_FileInput_vue_vue_type_template_id_6c71a2d3_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/pages/trackers/New.vue":
/*!*********************************************!*\
  !*** ./resources/js/pages/trackers/New.vue ***!
  \*********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _New_vue_vue_type_template_id_530bb995___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./New.vue?vue&type=template&id=530bb995& */ "./resources/js/pages/trackers/New.vue?vue&type=template&id=530bb995&");
/* harmony import */ var _New_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./New.vue?vue&type=script&lang=js& */ "./resources/js/pages/trackers/New.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _New_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _New_vue_vue_type_template_id_530bb995___WEBPACK_IMPORTED_MODULE_0__["render"],
  _New_vue_vue_type_template_id_530bb995___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/trackers/New.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/pages/trackers/New.vue?vue&type=script&lang=js&":
/*!**********************************************************************!*\
  !*** ./resources/js/pages/trackers/New.vue?vue&type=script&lang=js& ***!
  \**********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_New_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./New.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/trackers/New.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_New_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/trackers/New.vue?vue&type=template&id=530bb995&":
/*!****************************************************************************!*\
  !*** ./resources/js/pages/trackers/New.vue?vue&type=template&id=530bb995& ***!
  \****************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_New_vue_vue_type_template_id_530bb995___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./New.vue?vue&type=template&id=530bb995& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/trackers/New.vue?vue&type=template&id=530bb995&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_New_vue_vue_type_template_id_530bb995___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_New_vue_vue_type_template_id_530bb995___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);