import index from 'belt/core/js/components/users/ctlr/index';
import create from 'belt/core/js/components/users/ctlr/create';
import edit  from 'belt/core/js/components/users/ctlr/edit';
import roles  from 'belt/core/js/components/users/ctlr/roles';

export default [
    {path: '/users', component: index, canReuse: false, name: 'users'},
    {path: '/users/create', component: create, name: 'users.create'},
    {path: '/users/edit/:id', component: edit, name: 'users.edit'},
    {path: '/users/edit/:id/roles', component: roles, name: 'users.roles'},
    {path: '/self', component: edit, name: 'users.self'},
]