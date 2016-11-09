import userIndex from './components/user/ctlr-index';
import userCreate from './components/user/ctlr-create';
import userEdit from './components/user/ctlr-edit';
import roleIndex from './components/role/ctlr-index';
import roleCreate from './components/role/ctlr-create';
import roleEdit from './components/role/ctlr-edit';

export default class OhioCore {

    constructor(components = []) {
        this.components = [];

        _(components).forEach((value, index) => {
            this.addComponent(value);
        });

        if ($('#ohio-core').length > 0) {

            const router = new VueRouter({
                routes: [
                    {path: '/users', component: userIndex, canReuse: false, name: 'userIndex'},
                    {path: '/users/create', component: userCreate, name: 'userCreate'},
                    {path: '/users/edit/:id', component: userEdit, name: 'userEdit'},
                    {path: '/roles', component: roleIndex, name: 'roleIndex'},
                    {path: '/roles/create', component: roleCreate, name: 'roleCreate'},
                    {path: '/roles/edit/:id', component: roleEdit, name: 'roleEdit'}
                ],
                mode: 'history',
                base: '/admin/ohio/core'
            });

            const app = new Vue({router}).$mount('#ohio-core');
        }
    }

    addComponent(Class) {
        this.components[Class.name] = new Class();
    }
}