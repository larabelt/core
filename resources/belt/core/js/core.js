import alerts from 'belt/core/js/alerts/routes';
import roles from 'belt/core/js/roles/routes';
import teams from 'belt/core/js/teams/routes';
import users from 'belt/core/js/users/routes';
import store from 'belt/core/js/store/index';
import tinymce_directive from 'belt/core/js/directives/tinymce';

import column_sorter from 'belt/core/js/base/column-sorter';
import dropdown from 'belt/core/js/base/dropdown';
import heading from 'belt/core/js/base/heading';
import pagination from 'belt/core/js/base/pagination.vue';
import modals from 'belt/core/js/base/modals/modals.vue';
import modalDelete from 'belt/core/js/base/modals/modal-delete.vue';

import meta from 'belt/core/js/mixins/meta/index';

Vue.mixin(meta);
Vue.component('column-sorter', column_sorter);
Vue.component('dropdown', dropdown);
Vue.component('heading', heading);
Vue.component('pagination', pagination);
Vue.component('modals', modals);
Vue.component('modal-delete', modalDelete);
Vue.directive('tinymce', tinymce_directive);

window.Events = new Vue({});

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

            router.addRoutes(alerts);
            router.addRoutes(roles);
            router.addRoutes(teams);
            router.addRoutes(users);

            const app = new Vue({router, store}).$mount('#belt-core');
        }

        let modals = new Vue({
            el: '#vue-modals'
        });
    }

    addComponent(Class) {
        this.components[Class.name] = new Class();
    }
}