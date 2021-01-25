(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[9],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/modals/CreateUserModal.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/modals/CreateUserModal.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************/
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
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      show: false,
      user: {
        id: null,
        name: null,
        email: null,
        password: null,
        brand_id: -1,
        role: -1
      },
      resetPassword: false,
      title: "Add new user"
    };
  },
  created: function created() {
    var _this = this;

    document.addEventListener("keydown", function (e) {
      if (e.key == "Escape" && _this.show) {
        _this.dismiss();
      }
    }); // Load roles

    this.$store.dispatch("fetchRoles");
  },
  methods: {
    open: function open(user, resetPassword) {
      if (typeof user !== "undefined") this.user = user;
      if (typeof user !== "undefined" && typeof user.id !== "undefined" && typeof resetPassword === "undefined") this.title = "Edit " + user.name.toUpperCase();

      if (typeof user !== "undefined" && typeof user.id !== "undefined" && typeof resetPassword !== "undefined") {
        this.title = "Reset password for " + user.name.toUpperCase();
        this.resetPassword = true;
      } // Ignore password


      this.user.password = null; // Set role

      if (typeof this.user.role_id === "number") this.user.role = this.user.role_id;else this.user.role = -1;
      if (this.is_superadmin) this.user.role = 'super';
      this.show = true;
    },
    close: function close() {
      this.show = false;
      this.user = {
        id: null,
        name: null,
        email: null,
        password: null,
        brand_id: -1,
        role: -1
      };
      this.resetPassword = false;
    },
    submit: function submit() {
      var action = this.user.id !== null ? "update" : "create";
      this.$emit(this.resetPassword ? "custom" : action, this.user);
      this.close();
    }
  },
  computed: _objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapGetters"])(["brands", "roles"]))
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/UsersPage.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/UsersPage.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _components_modals_CreateUserModal__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../components/modals/CreateUserModal */ "./resources/js/components/modals/CreateUserModal.vue");
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
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


/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    CreateUserModal: _components_modals_CreateUserModal__WEBPACK_IMPORTED_MODULE_0__["default"]
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
  computed: _objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_1__["mapGetters"])(["users", "AuthenticatedUser"])),
  methods: {
    loadUsers: function loadUsers() {
      this.$store.dispatch("fetchUsers")["catch"](function (error) {});
    },
    addUser: function addUser() {
      this.$refs.userFormModal.open();
    },
    editUser: function editUser(user) {
      this.$refs.userFormModal.open(Object.assign({}, user));
    },
    deleteUser: function deleteUser(user) {
      this.$refs.confirmDeleteUserModal.open("Are sure to delete this user?", user);
    },
    banUser: function banUser(user) {
      this.$refs.confirmBanUserModal.open("Are sure to " + (user.banned ? "unban" : "ban") + " this user?", user);
    },
    resetUserPassword: function resetUserPassword(user) {
      this.$refs.userFormModal.open(user, true);
    },
    deleteUserAction: function deleteUserAction(user) {
      var _this = this;

      if (typeof user.uuid === "undefined") this.showError();
      this.$store.dispatch("deleteUser", user.uuid).then(function (response) {
        _this.$refs.usersDT.reloadData();

        _this.showSuccess({
          message: "Successfully deleted user '" + user.name + "'"
        });
      })["catch"](function (error) {
        _this.showError({
          message: error.message
        });
      });
    },
    banUserAction: function banUserAction(user) {
      var _this2 = this;

      this.$store.dispatch("banUser", user.uuid).then(function (response) {
        _this2.$refs.usersDT.reloadData();

        _this2.showSuccess({
          message: response.message
        });
      })["catch"](function (error) {
        _this2.showError({
          message: error.message
        });
      });
    },
    create: function create(user) {
      var _this3 = this;

      this.$store.dispatch("addNewUser", user).then(function (response) {
        if (response.success) {
          _this3.$refs.usersDT.reloadData();

          _this3.showSuccess({
            message: "user ".concat(response.content.name, " created successfuly!")
          });
        } else {
          throw new Error("Something going wrong!");
        }
      })["catch"](function (error) {
        _this3.showError({
          title: "Error",
          message: "".concat(error.response.data.message)
        });
      });
    },
    update: function update(user) {
      var _this4 = this;

      this.$store.dispatch("editUser", user).then(function (response) {
        _this4.$refs.usersDT.reloadData();

        _this4.showSuccess({
          message: "user ".concat(response.content.name, " updated successfuly!")
        });
      })["catch"](function (error) {
        _this4.showError({
          title: "Error",
          message: "".concat(error.response.data.message)
        });
      });
    },
    resetPassword: function resetPassword(user) {
      var _this5 = this;

      this.$store.dispatch("resetUser", user).then(function (response) {
        _this5.$refs.usersDT.reloadData();

        _this5.showSuccess({
          message: "Password for user ".concat(response.content.name, " reseted successfuly!")
        });
      })["catch"](function (error) {
        _this5.showError({
          title: "Error",
          message: "".concat(error.response.data.message)
        });
      });
    }
  },
  mounted: function mounted() {
    // Load users
    if (typeof this.users === "undefined" || this.users === null || Object.values(this.users).length === 0) this.loadUsers();
  },
  data: function data() {
    return {
      columns: [{
        name: 'name',
        field: 'name'
      }, {
        name: 'email',
        field: 'email'
      }, {
        name: 'account type',
        field: 'role_name'
      }, {
        name: 'brands',
        field: 'brands',
        callback: function callback(row) {
          if (!row.brands) return '-';
          var html = '';
          row.brands.map(function (item, index) {
            // html += '<li>' + item.name.toUpperCase() + '</li>';
            html += '<span class="badge badge-success">' + item.name.toUpperCase() + '</span>';
            ;
          });
          return html;
        }
      }, {
        name: 'last login',
        field: 'last_login',
        isTimeAgo: true
      }, {
        name: 'Joined at',
        field: 'created_at',
        isTimeAgo: true
      }],
      showAddUserModal: false
    };
  }
});

/***/ }),

/***/ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/modals/CreateUserModal.vue?vue&type=style&index=0&id=a540ee70&scoped=true&lang=css&":
/*!****************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/modals/CreateUserModal.vue?vue&type=style&index=0&id=a540ee70&scoped=true&lang=css& ***!
  \****************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "\n.radio-group[data-v-a540ee70] {\r\n    display: flex;\r\n    align-items: center;\r\n    margin: 1.2rem 0;\n}\n.radio-group>label+label[data-v-a540ee70] {\r\n    margin-left: 0.5rem;\n}\n.radio-group label[data-v-a540ee70] {\r\n    display: flex;\r\n    align-items: center;\n}\n.radio-group label span[data-v-a540ee70] {\r\n    margin-left: 0.3rem;\n}\n.radio-group span[data-v-a540ee70] {\r\n    font-weight: 100;\r\n    font-size: 0.8rem;\n}\r\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/modals/CreateUserModal.vue?vue&type=style&index=0&id=a540ee70&scoped=true&lang=css&":
/*!********************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/modals/CreateUserModal.vue?vue&type=style&index=0&id=a540ee70&scoped=true&lang=css& ***!
  \********************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../../node_modules/css-loader??ref--6-1!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--6-2!../../../../node_modules/vue-loader/lib??vue-loader-options!./CreateUserModal.vue?vue&type=style&index=0&id=a540ee70&scoped=true&lang=css& */ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/modals/CreateUserModal.vue?vue&type=style&index=0&id=a540ee70&scoped=true&lang=css&");

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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/modals/CreateUserModal.vue?vue&type=template&id=a540ee70&scoped=true&":
/*!*************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/modals/CreateUserModal.vue?vue&type=template&id=a540ee70&scoped=true& ***!
  \*************************************************************************************************************************************************************************************************************************************/
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
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.user.id,
                expression: "user.id"
              }
            ],
            attrs: { type: "hidden", name: "id" },
            domProps: { value: _vm.user.id },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.$set(_vm.user, "id", $event.target.value)
              }
            }
          }),
          _vm._v(" "),
          _c(
            "div",
            {
              directives: [
                {
                  name: "show",
                  rawName: "v-show",
                  value: !_vm.resetPassword,
                  expression: "!resetPassword"
                }
              ],
              staticClass: "control"
            },
            [
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.user.name,
                    expression: "user.name"
                  }
                ],
                attrs: { type: "text", placeholder: "User name", required: "" },
                domProps: { value: _vm.user.name },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.$set(_vm.user, "name", $event.target.value)
                  }
                }
              })
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
                  value: !_vm.resetPassword,
                  expression: "!resetPassword"
                }
              ],
              staticClass: "control"
            },
            [
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.user.email,
                    expression: "user.email"
                  }
                ],
                attrs: { type: "email", placeholder: "Email", required: "" },
                domProps: { value: _vm.user.email },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.$set(_vm.user, "email", $event.target.value)
                  }
                }
              })
            ]
          ),
          _vm._v(" "),
          _c("div", { staticClass: "control" }, [
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.user.password,
                  expression: "user.password"
                }
              ],
              attrs: { type: "text", placeholder: "Password", required: "" },
              domProps: { value: _vm.user.password },
              on: {
                input: function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.$set(_vm.user, "password", $event.target.value)
                }
              }
            })
          ]),
          _vm._v(" "),
          _c(
            "div",
            {
              directives: [
                {
                  name: "show",
                  rawName: "v-show",
                  value: !_vm.resetPassword,
                  expression: "!resetPassword"
                }
              ],
              ref: "userBrand",
              staticClass: "control"
            },
            [
              _c("label", { attrs: { for: "brand" } }, [_vm._v("Brand")]),
              _vm._v(" "),
              _c(
                "select",
                {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.user.brand_id,
                      expression: "user.brand_id"
                    }
                  ],
                  attrs: { id: "brand" },
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
                      _vm.$set(
                        _vm.user,
                        "brand_id",
                        $event.target.multiple
                          ? $$selectedVal
                          : $$selectedVal[0]
                      )
                    }
                  }
                },
                [
                  _c(
                    "option",
                    {
                      attrs: { value: "-1" },
                      domProps: { selected: _vm.user.brand_id }
                    },
                    [_vm._v("Select a brand")]
                  ),
                  _vm._v(" "),
                  _vm._l(_vm.brands, function(item) {
                    return _c(
                      "option",
                      {
                        key: item.id,
                        domProps: {
                          value: item.id,
                          selected: _vm.user.brand_id
                        }
                      },
                      [_vm._v(_vm._s(item.name))]
                    )
                  })
                ],
                2
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
                  value: !_vm.resetPassword,
                  expression: "!resetPassword"
                }
              ],
              staticClass: "control"
            },
            [
              _c("label", { attrs: { for: "role" } }, [_vm._v("Role")]),
              _vm._v(" "),
              _c(
                "select",
                {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.user.role,
                      expression: "user.role"
                    }
                  ],
                  attrs: { id: "role" },
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
                      _vm.$set(
                        _vm.user,
                        "role",
                        $event.target.multiple
                          ? $$selectedVal
                          : $$selectedVal[0]
                      )
                    }
                  }
                },
                [
                  _c(
                    "option",
                    {
                      attrs: { value: "-1" },
                      domProps: { selected: _vm.user.role }
                    },
                    [_vm._v("Select a role")]
                  ),
                  _vm._v(" "),
                  _c(
                    "option",
                    {
                      attrs: { value: "super" },
                      domProps: { selected: _vm.user.role }
                    },
                    [_vm._v("Super Admin")]
                  ),
                  _vm._v(" "),
                  _vm._l(_vm.roles, function(role) {
                    return _c(
                      "option",
                      {
                        key: role.id,
                        domProps: { value: role.id, selected: _vm.user.role }
                      },
                      [_vm._v(_vm._s(role.name))]
                    )
                  })
                ],
                2
              )
            ]
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
                  _vm._s(typeof _vm.user.id === "number" ? "Update" : "Create")
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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/UsersPage.vue?vue&type=template&id=90357404&":
/*!*******************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/UsersPage.vue?vue&type=template&id=90357404& ***!
  \*******************************************************************************************************************************************************************************************************/
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
    { staticClass: "users" },
    [
      _c("div", { staticClass: "hero" }, [
        _c("div", { staticClass: "hero__intro" }, [
          _c("h1", [_vm._v("Users")]),
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
                  return _vm.addUser()
                }
              }
            },
            [_vm._v("Add new user")]
          )
        ])
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "p-1" }, [
        _vm.$can("list", "user") ||
        (_vm.AuthenticatedUser && _vm.AuthenticatedUser.is_superadmin)
          ? _c(
              "div",
              { staticClass: "datatable-scroll" },
              [
                _c(
                  "DataTable",
                  {
                    ref: "usersDT",
                    attrs: {
                      nativeData: _vm.users,
                      fetchMethod: "fetchUsers",
                      columns: _vm.columns,
                      cssClasses: "table-card"
                    },
                    scopedSlots: _vm._u(
                      [
                        {
                          key: "body-row",
                          fn: function(row) {
                            return _c("td", {}, [
                              _vm.$can("edit", "user") ||
                              (_vm.AuthenticatedUser &&
                                _vm.AuthenticatedUser.is_superadmin)
                                ? _c(
                                    "button",
                                    {
                                      staticClass: "btn icon-link",
                                      attrs: { title: "Reset user password" },
                                      on: {
                                        click: function($event) {
                                          return _vm.resetUserPassword(
                                            row.data.original
                                          )
                                        }
                                      }
                                    },
                                    [_c("i", { staticClass: "fas fa-key" })]
                                  )
                                : _vm._e(),
                              _vm._v(" "),
                              (_vm.$can("edit", "user") ||
                                (_vm.AuthenticatedUser &&
                                  _vm.AuthenticatedUser.is_superadmin)) &&
                              _vm.AuthenticatedUser.uuid !==
                                row.data.original.uuid
                                ? _c(
                                    "button",
                                    {
                                      staticClass: "btn icon-link",
                                      attrs: { title: "Edit user" },
                                      on: {
                                        click: function($event) {
                                          return _vm.editUser(row.data.original)
                                        }
                                      }
                                    },
                                    [_c("i", { staticClass: "fas fa-pen" })]
                                  )
                                : _vm._e(),
                              _vm._v(" "),
                              (_vm.$can("ban", "user") ||
                                (_vm.AuthenticatedUser &&
                                  _vm.AuthenticatedUser.is_superadmin)) &&
                              _vm.AuthenticatedUser.uuid !==
                                row.data.original.uuid
                                ? _c(
                                    "button",
                                    {
                                      staticClass: "btn icon-link",
                                      attrs: { title: "Ban user" },
                                      on: {
                                        click: function($event) {
                                          return _vm.banUser(row.data.original)
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
                                              value: row.data.original.banned,
                                              expression:
                                                "row.data.original.banned"
                                            }
                                          ],
                                          staticClass:
                                            "svg-inline--fa fa-redo-alt fa-w-16",
                                          attrs: {
                                            "data-v-4b997e69": "",
                                            "aria-hidden": "true",
                                            focusable: "false",
                                            "data-prefix": "fas",
                                            "data-icon": "redo-alt",
                                            role: "img",
                                            xmlns: "http://www.w3.org/2000/svg",
                                            viewBox: "0 0 512 512",
                                            "data-fa-i2svg": ""
                                          }
                                        },
                                        [
                                          _c("path", {
                                            attrs: {
                                              fill: "currentColor",
                                              d:
                                                "M256.455 8c66.269.119 126.437 26.233 170.859 68.685l35.715-35.715C478.149 25.851 504 36.559 504 57.941V192c0 13.255-10.745 24-24 24H345.941c-21.382 0-32.09-25.851-16.971-40.971l41.75-41.75c-30.864-28.899-70.801-44.907-113.23-45.273-92.398-.798-170.283 73.977-169.484 169.442C88.764 348.009 162.184 424 256 424c41.127 0 79.997-14.678 110.629-41.556 4.743-4.161 11.906-3.908 16.368.553l39.662 39.662c4.872 4.872 4.631 12.815-.482 17.433C378.202 479.813 319.926 504 256 504 119.034 504 8.001 392.967 8 256.002 7.999 119.193 119.646 7.755 256.455 8z"
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
                                              value: !row.data.original.banned,
                                              expression:
                                                "!row.data.original.banned"
                                            }
                                          ],
                                          staticClass:
                                            "svg-inline--fa fa-ban fa-w-16",
                                          attrs: {
                                            "data-v-4b997e69": "",
                                            "aria-hidden": "true",
                                            focusable: "false",
                                            "data-prefix": "fas",
                                            "data-icon": "ban",
                                            role: "img",
                                            xmlns: "http://www.w3.org/2000/svg",
                                            viewBox: "0 0 512 512",
                                            "data-fa-i2svg": ""
                                          }
                                        },
                                        [
                                          _c("path", {
                                            attrs: {
                                              fill: "currentColor",
                                              d:
                                                "M256 8C119.034 8 8 119.033 8 256s111.034 248 248 248 248-111.034 248-248S392.967 8 256 8zm130.108 117.892c65.448 65.448 70 165.481 20.677 235.637L150.47 105.216c70.204-49.356 170.226-44.735 235.638 20.676zM125.892 386.108c-65.448-65.448-70-165.481-20.677-235.637L361.53 406.784c-70.203 49.356-170.226 44.736-235.638-20.676z"
                                            }
                                          })
                                        ]
                                      )
                                    ]
                                  )
                                : _vm._e(),
                              _vm._v(" "),
                              (_vm.$can("delete", "user") ||
                                (_vm.AuthenticatedUser &&
                                  _vm.AuthenticatedUser.is_superadmin)) &&
                              _vm.AuthenticatedUser.uuid !==
                                row.data.original.uuid
                                ? _c(
                                    "button",
                                    {
                                      staticClass: "btn icon-link",
                                      attrs: { title: "Delete user" },
                                      on: {
                                        click: function($event) {
                                          return _vm.deleteUser(
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
                      3574816149
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
      _c("CreateUserModal", {
        ref: "userFormModal",
        on: {
          create: _vm.create,
          update: _vm.update,
          custom: _vm.resetPassword
        }
      }),
      _vm._v(" "),
      _c("ConfirmationModal", {
        ref: "confirmDeleteUserModal",
        on: { custom: _vm.deleteUserAction }
      }),
      _vm._v(" "),
      _c("ConfirmationModal", {
        ref: "confirmBanUserModal",
        on: { custom: _vm.banUserAction }
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
    return _c("li", [_c("a", { attrs: { href: "#" } }, [_vm._v("Users")])])
  }
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/modals/CreateUserModal.vue":
/*!************************************************************!*\
  !*** ./resources/js/components/modals/CreateUserModal.vue ***!
  \************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _CreateUserModal_vue_vue_type_template_id_a540ee70_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./CreateUserModal.vue?vue&type=template&id=a540ee70&scoped=true& */ "./resources/js/components/modals/CreateUserModal.vue?vue&type=template&id=a540ee70&scoped=true&");
/* harmony import */ var _CreateUserModal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./CreateUserModal.vue?vue&type=script&lang=js& */ "./resources/js/components/modals/CreateUserModal.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _CreateUserModal_vue_vue_type_style_index_0_id_a540ee70_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./CreateUserModal.vue?vue&type=style&index=0&id=a540ee70&scoped=true&lang=css& */ "./resources/js/components/modals/CreateUserModal.vue?vue&type=style&index=0&id=a540ee70&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _CreateUserModal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _CreateUserModal_vue_vue_type_template_id_a540ee70_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _CreateUserModal_vue_vue_type_template_id_a540ee70_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "a540ee70",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/modals/CreateUserModal.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/modals/CreateUserModal.vue?vue&type=script&lang=js&":
/*!*************************************************************************************!*\
  !*** ./resources/js/components/modals/CreateUserModal.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateUserModal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./CreateUserModal.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/modals/CreateUserModal.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateUserModal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/modals/CreateUserModal.vue?vue&type=style&index=0&id=a540ee70&scoped=true&lang=css&":
/*!*********************************************************************************************************************!*\
  !*** ./resources/js/components/modals/CreateUserModal.vue?vue&type=style&index=0&id=a540ee70&scoped=true&lang=css& ***!
  \*********************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateUserModal_vue_vue_type_style_index_0_id_a540ee70_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/style-loader!../../../../node_modules/css-loader??ref--6-1!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--6-2!../../../../node_modules/vue-loader/lib??vue-loader-options!./CreateUserModal.vue?vue&type=style&index=0&id=a540ee70&scoped=true&lang=css& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/modals/CreateUserModal.vue?vue&type=style&index=0&id=a540ee70&scoped=true&lang=css&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateUserModal_vue_vue_type_style_index_0_id_a540ee70_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateUserModal_vue_vue_type_style_index_0_id_a540ee70_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateUserModal_vue_vue_type_style_index_0_id_a540ee70_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateUserModal_vue_vue_type_style_index_0_id_a540ee70_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));


/***/ }),

/***/ "./resources/js/components/modals/CreateUserModal.vue?vue&type=template&id=a540ee70&scoped=true&":
/*!*******************************************************************************************************!*\
  !*** ./resources/js/components/modals/CreateUserModal.vue?vue&type=template&id=a540ee70&scoped=true& ***!
  \*******************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateUserModal_vue_vue_type_template_id_a540ee70_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./CreateUserModal.vue?vue&type=template&id=a540ee70&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/modals/CreateUserModal.vue?vue&type=template&id=a540ee70&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateUserModal_vue_vue_type_template_id_a540ee70_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateUserModal_vue_vue_type_template_id_a540ee70_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/pages/UsersPage.vue":
/*!******************************************!*\
  !*** ./resources/js/pages/UsersPage.vue ***!
  \******************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _UsersPage_vue_vue_type_template_id_90357404___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./UsersPage.vue?vue&type=template&id=90357404& */ "./resources/js/pages/UsersPage.vue?vue&type=template&id=90357404&");
/* harmony import */ var _UsersPage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./UsersPage.vue?vue&type=script&lang=js& */ "./resources/js/pages/UsersPage.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _UsersPage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _UsersPage_vue_vue_type_template_id_90357404___WEBPACK_IMPORTED_MODULE_0__["render"],
  _UsersPage_vue_vue_type_template_id_90357404___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/UsersPage.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/pages/UsersPage.vue?vue&type=script&lang=js&":
/*!*******************************************************************!*\
  !*** ./resources/js/pages/UsersPage.vue?vue&type=script&lang=js& ***!
  \*******************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_UsersPage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./UsersPage.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/UsersPage.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_UsersPage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/UsersPage.vue?vue&type=template&id=90357404&":
/*!*************************************************************************!*\
  !*** ./resources/js/pages/UsersPage.vue?vue&type=template&id=90357404& ***!
  \*************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_UsersPage_vue_vue_type_template_id_90357404___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./UsersPage.vue?vue&type=template&id=90357404& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/UsersPage.vue?vue&type=template&id=90357404&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_UsersPage_vue_vue_type_template_id_90357404___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_UsersPage_vue_vue_type_template_id_90357404___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);