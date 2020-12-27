
import axios from 'axios';
import SecureLS from "secure-ls";

try{
    // Set Authorization header
    let ls = new SecureLS();
    let user = JSON.parse(ls.get("user"));
    axios.defaults.headers.common['Authorization'] = `Bearer ${user.token}`;
}catch(e){}