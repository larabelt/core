import index from 'belt/core/js/users/ctlr/index';
import create from 'belt/core/js/users/ctlr/create';
import edit  from 'belt/core/js/users/ctlr/edit';
import access  from 'belt/core/js/users/access';

export default [
    {path: '/users', component: index, canReuse: false, name: 'users'},
    {path: '/users/create', component: create, name: 'users.create'},
    {path: '/users/edit/:id', component: edit, name: 'users.edit'},
    {path: '/users/edit/:id/access', component: access, name: 'users.access'},
    {path: '/self', component: edit, name: 'users.self'},
]