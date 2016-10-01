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
            const Foo = { template: '<div>foo</div>' }

            const Users = require('./components/user/user');

            const router = new VueRouter({
                routes: [
                    { path: '/users', component: Users, canReuse: false, name: 'userIndex' },
                    { path: '/users/create', component: Foo, name: 'userCreate' }
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