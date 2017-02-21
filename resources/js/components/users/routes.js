import index from './ctlr/index';
import create from './ctlr/create';
import edit  from './ctlr/edit';

export default [
    {path: '/users', component: index, canReuse: false, name: 'users'},
    {path: '/users/create', component: create, name: 'users.create'},
    {path: '/users/edit/:id', component: edit, name: 'users.edit'},
    {path: '/self', component: edit, name: 'users.self'},
]