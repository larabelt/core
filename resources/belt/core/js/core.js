import 'belt/core/js/belt-bootstrap';

import alerts from 'belt/core/js/alerts/routes';
import roles from 'belt/core/js/roles/routes';
import teams from 'belt/core/js/teams/routes';
import users from 'belt/core/js/users/routes';
import workRequests from 'belt/core/js/work-requests/routes';
import store from 'belt/core/js/store/index';

import column_sorter from 'belt/core/js/base/column-sorter';
import dropdown from 'belt/core/js/base/dropdown';
import heading from 'belt/core/js/base/heading';
import pagination from 'belt/core/js/base/pagination';
import modals from 'belt/core/js/base/modals/modals.vue';
import modalDelete from 'belt/core/js/base/modals/modal-delete.vue';

import meta from 'belt/core/js/mixins/meta/index';

import History from 'belt/core/js/helpers/history';

Vue.mixin(meta);
Vue.component('column-sorter', column_sorter);
Vue.component('dropdown', dropdown);
Vue.component('heading', heading);
Vue.component('pagination', pagination);
Vue.component('modals', modals);
Vue.component('modal-delete', modalDelete);

import inputEditor from 'belt/core/js/inputs/editor';
import inputSelect from 'belt/core/js/inputs/select';
import inputText from 'belt/core/js/inputs/text';
import inputTextarea from 'belt/core/js/inputs/textarea';
Vue.component('input-editor', inputEditor);
Vue.component('input-select', inputSelect);
Vue.component('input-text', inputText);
Vue.component('input-textarea', inputTextarea);

import tinymce from 'belt/core/js/editors/tinymce.vue';
import codemirror from 'belt/core/js/editors/codemirror.vue';
import textarea from 'belt/core/js/editors/textarea.vue';
switch(process.env.MIX_LARABELT_EDITOR)
{
    case 'codemirror':
        Vue.component('belt-editor', codemirror);
        break;
    case 'tinymce':
        Vue.component('belt-editor', tinymce);
        break;
    default:
        Vue.component('belt-editor', textarea);
}

window.Events = new Vue({});
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

            router.addRoutes(alerts);
            router.addRoutes(roles);
            router.addRoutes(teams);
            router.addRoutes(users);
            router.addRoutes(workRequests);

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