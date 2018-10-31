import 'belt/core/js/belt-bootstrap';
import 'belt/core/js/bootstrap/buttons';
import 'belt/core/js/bootstrap/inputs';
import 'belt/core/js/bootstrap/editors';
import 'belt/core/js/bootstrap/filters';
import 'belt/core/js/bootstrap/functions';
import 'belt/core/js/bootstrap/misc';
import 'belt/core/js/bootstrap/mixins';
import 'belt/core/js/bootstrap/tiles';

import roles from 'belt/core/js/roles/routes';
import teams from 'belt/core/js/teams/routes';
import users from 'belt/core/js/users/routes';
import store from 'belt/core/js/store/index';

import localeDropdown from 'belt/core/js/base/locale-dropdown';
import modals from 'belt/core/js/base/modals/modals.vue';

window.Events = new Vue({});

import Cookies from 'belt/core/js/helpers/cookies';

window.Cookies = new Cookies({});

import History from 'belt/core/js/helpers/history';

window.History = new History({});

window.larabelt = _.get(window, 'larabelt', {});
window.larabelt.core = _.get(window, 'larabelt.core', {});

export default class BeltCore {

    constructor(components = []) {
        this.components = [];

        _(components).forEach((value, index) => {
            this.addComponent(value);
        });

        if ($('#belt-core').length > 0) {

            const router = new VueRouter({
                mode: 'history',
                base: '/admin/belt/core',
                routes: []
            });

            router.addRoutes(roles);
            router.addRoutes(teams);
            router.addRoutes(users);

            new Vue({router, store}).$mount('#belt-core');
        }

        if ($('#belt-locale-dropdown').length > 0) {
            let router = new VueRouter({mode: 'history'});
            Vue.component('locale-dropdown', localeDropdown);
            new Vue({router, store, el: '#belt-locale-dropdown'});
        }

        new Vue({
            el: '#vue-modals',
            components: {
                modals: modals
            }
        });
    }

    addComponent(Class) {
        this.components[Class.name] = new Class();
    }
}