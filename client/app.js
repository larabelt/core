let $ = require('jquery');
let lodash = require('lodash');
//let Vue = require('vue');
import Vue from 'vue';
import VueResource from 'vue-resource';
import VueRouter from 'vue-router';

Vue.use(VueResource);
Vue.use(VueRouter);
Vue.config.devtools = true;

export default class OhioCMS {

    constructor(components = []) {
        this.components = [];

        lodash(components).forEach((value, index) => {
            this.addComponent(value);
        });

        if( $('#core-vue').length > 0 )
        {
            const Foo = {template: `<div>Foo</div>`};
            const Users = require('./components/user/user');
            const UserCreate = require('./components/user/user-create');
            const UserEdit = require('./components/user/user-edit');
            const Roles = require('./components/user-role/user-role');
            const RolesCreate = require('./components/user-role/user-role-create');
            const RolesEdit = require('./components/user-role/user-role-edit');

            const router = new VueRouter({
                routes: [
                    { path: '/users', component: Users, canReuse: false, name: 'userIndex' },
                    { path: '/users/create', component: UserCreate, name: 'userCreate' },
                    { path: '/users/edit/:id', component: UserEdit, name: 'userEdit' },
                    { path: '/roles', component: Roles, name: 'roleIndex' },
                    { path: '/roles/create', component: RolesCreate, name: 'roleCreate' },
                    { path: '/roles/edit/:id', component: RolesEdit, name: 'roleEdit' }
                ],
                mode: 'history',
                base: '/admin/ohio/core'
            })
            const app = new Vue({
                router
            }).$mount('#core-vue');
        }
    }

    addComponent(Class) {
        this.components[Class.name] = new Class();
    }
}