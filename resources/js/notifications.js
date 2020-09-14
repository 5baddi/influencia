import Vue from 'vue'
import VueNotifications from 'vue-notifications'
import miniToastr from 'mini-toastr'

const toastTypes = {
    success: 'success',
    error: 'error',
    info: 'info',
    warn: 'warn'
}

// miniToastr.init({
//     types: toastTypes,
// })

miniToastr.init({
    types: toastTypes,
    style: {
        '.mini-toastr': {
            position: 'fixed',
            'z-index': 99999,
            right: '16px',
            left: "auto",
            top: 'auto',
            bottom: "16px"
        },
        '.mini-toastr__notification': {
            "font-family": 'inherit',
            cursor: 'pointer',
            padding: '12px 18px',
            margin: '0 0 6px 0',
            'background-color': '#000',
            opacity: 0.95,
            color: '#fff',
            "border-radius": '4px',
            "box-shadow": "#00000080 2px 1px 13px",
            width: '400px',
            '&.-error': {
                'background-color': '#f44336'
            },
            '&.-warn': {
                'background-color': '#F5AA1E'
            },
            '&.-success': {
                'background-color': '#09d261'
            },
            '&.-info': {
                'background-color': '#039be5'
            },
            '&:hover': {
                opacity: 1,
            }
        },
        '.mini-toastr-notification__title': {
            'font-weight': '400',
            'margin-bottom': '6px'
        },
        '.mini-toastr-notification__message': {
            'font-size': '14px',
            'font-weight': '100',
            display: 'inline-block',
            'vertical-align': 'middle',
            width: '200px',
            padding: '0 12px'
        }
    }
})


function toast({ title, message, type, timeout, cb }) {
    return miniToastr[type](message, title, timeout, cb)
}

const options = {
    success: toast,
    error: toast,
    info: toast,
    warn: toast
}

Vue.use(VueNotifications, options)
