import index from './ctlr/index';
import create from './ctlr/create';
import edit  from './ctlr/edit';

export default [
    {path: '/roles', component: index, canReuse: false, name: 'roles'},
    {path: '/roles/create', component: create, name: 'roles.create'},
    {path: '/roles/edit/:id', component: edit, name: 'roles.edit'},
    {path: '/self', component: edit, name: 'roles.self'},
]