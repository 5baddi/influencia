(window.webpackJsonp=window.webpackJsonp||[]).push([[18],{Fmgl:function(t,e,r){"use strict";r.r(e);var n=r("L2JU");function s(t,e){var r=Object.keys(t);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(t);e&&(n=n.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),r.push.apply(r,n)}return r}function i(t){for(var e=1;e<arguments.length;e++){var r=null!=arguments[e]?arguments[e]:{};e%2?s(Object(r),!0).forEach((function(e){c(t,e,r[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(r)):s(Object(r)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(r,e))}))}return t}function c(t,e,r){return e in t?Object.defineProperty(t,e,{value:r,enumerable:!0,configurable:!0,writable:!0}):t[e]=r,t}var a={computed:i(i({},Object(n.b)(["AuthenticatedUser","stories"])),{},{activeBrand:function(){return null!==this.AuthenticatedUser&&void 0!==this.AuthenticatedUser&&this.AuthenticatedUser.selected_brand?this.AuthenticatedUser.selected_brand:null}}),methods:{addStory:function(){}}},o=r("KHd+"),u=Object(o.a)(a,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"listing"},[r("div",{staticClass:"hero"},[t._m(0),t._v(" "),t.$can("create","tracker")||t.AuthenticatedUser&&t.AuthenticatedUser.is_superadmin?r("div",{staticClass:"hero__actions"},[r("button",{staticClass:"btn btn-success",attrs:{disabled:!t.activeBrand},on:{click:function(e){return t.addStory()}}},[t._v("Add new story")])]):t._e()])])}),[function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"hero__intro"},[e("h1",[this._v("Stories")]),this._v(" "),e("ul",{staticClass:"breadcrumbs"},[e("li",[e("a",{attrs:{href:"#"}},[this._v("Dashboard")])]),this._v(" "),e("li",[e("a",{attrs:{href:"#"}},[this._v("Stories")])])])])}],!1,null,null,null);e.default=u.exports}}]);