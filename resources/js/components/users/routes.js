import index from './ctlr/index';
import create from './ctlr/create';
import edit  from './ctlr/edit';
import roles  from './ctlr/roles';

export default [
    {path: '/users', component: index, canReuse: false, name: 'users'},
    {path: '/users/create', component: create, name: 'users.create'},
    {path: '/users/edit/:id', component: edit, name: 'users.edit'},
    {path: '/users/edit/:id/roles', component: roles, name: 'users.roles'},
    {path: '/self', component: edit, name: 'users.self'},
]