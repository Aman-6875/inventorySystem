//auth
let login = require('./components/auth/login.vue').default;
let register = require('./components/auth/register.vue').default;
let logout = require('./components/auth/logout.vue').default;
let forget_password = require('./components/auth/forget_password.vue').default;
//end auth

let home = require('./components/home.vue').default;
//employee
let store_employee = require('./components/employee/create.vue').default;
let employee = require('./components/employee/index.vue').default;
let editemployee = require('./components/employee/edit.vue').default;


export const routes = [
    { path: '/', component: login, name: '/' },
    { path: '/register', component: register, name:'register' },
    { path: '/logout', component: logout, name:'logout' },
    { path: '/forget-password', component: forget_password, name:'forget-password' },
    { path: '/home', component: home, name:'home' },

    //employee-routes
    { path: '/create-employee', component: store_employee, name:'store_employee'},
    { path: '/employee', component: employee, name:'employee'},
    { path: '/edit-employee/:id', component: editemployee, name:'edit-employee'},

  ]
