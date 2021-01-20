(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[17],{

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

/***/ "./resources/js/pages/trackers/New.vue":
/*!*********************************************!*\
  !*** ./resources/js/pages/trackers/New.vue ***!
  \*********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _New_vue_vue_type_template_id_530bb995___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./New.vue?vue&type=template&id=530bb995& */ "./resources/js/pages/trackers/New.vue?vue&type=template&id=530bb995&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");

var script = {}


/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_1__["default"])(
  script,
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