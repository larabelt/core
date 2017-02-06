import roleIndex from './components/role/ctlr-index';
import roleCreate from './components/role/ctlr-create';
import roleEdit from './components/role/ctlr-edit';
import teamIndex from './components/team/ctlr-index';
import teamCreate from './components/team/ctlr-create';
import teamEdit from './components/team/ctlr-edit';
import userIndex from './components/user/ctlr-index';
import userCreate from './components/user/ctlr-create';
import userEdit from './components/user/ctlr-edit';
import userSelf from './components/user/ctlr-self';
import store from 'ohio/core/js/store/index';
import tinymce_directive from './directives/tinymce';

Vue.directive('tinymce', tinymce_directive);

export default class OhioCore {

    constructor(components = []) {
        this.components = [];

        _(components).forEach((value, index) => {
            this.addComponent(value);
        });

        if ($('#ohio-core').length > 0) {

            const router = new VueRouter({
                routes: [
                    {path: '/roles', component: roleIndex, name: 'roleIndex'},
                    {path: '/roles/create', component: roleCreate, name: 'roleCreate'},
                    {path: '/roles/edit/:id', component: roleEdit, name: 'roleEdit'},
                    {path: '/teams', component: teamIndex, canReuse: false, name: 'teamIndex'},
                    {path: '/teams/create', component: teamCreate, name: 'teamCreate'},
                    {path: '/teams/edit/:id', component: teamEdit, name: 'teamEdit'},
                    {path: '/users', component: userIndex, canReuse: false, name: 'userIndex'},
                    {path: '/users/create', component: userCreate, name: 'userCreate'},
                    {path: '/users/edit/:id', component: userEdit, name: 'userEdit'},
                    {path: '/self', component: userSelf, name: 'userSelf'},
                ],
                mode: 'history',
                base: '/admin/ohio/core'
            });

            const app = new Vue({router, store}).$mount('#ohio-core');
        }
    }

    addComponent(Class) {
        this.components[Class.name] = new Class();
    }
}