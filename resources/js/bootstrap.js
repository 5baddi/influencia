
import axios from 'axios';
import SecureLS from "secure-ls";

try{
    // Init JQuery & Lodash
    window._ = require('lodash');
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
    require('bootstrap');

    // Set Authorization header
    let ls = new SecureLS();
    let user = JSON.parse(ls.get("user"));
    axios.defaults.headers.common['Authorization'] = `Bearer ${user.token}`;
}catch(e){}