import Users from './components/user/user';
import UserCreate from './components/user/user-create';
import UserEdit from './components/user/user-edit';
import Roles from './components/role/role';
import RolesCreate from './components/role/role-create';
import RolesEdit from './components/role/role-edit';

export default class OhioCMS {

    constructor(components = []) {
        this.components = [];

        _(components).forEach((value, index) => {
            this.addComponent(value);
        });

        if( $('#core-vue').length > 0 )
        {
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

            console.log(app);
        }
    }

    addComponent(Class) {
        this.components[Class.name] = new Class();
    }
}