import index from 'belt/core/js/roles/ctlr/index';
import create from 'belt/core/js/roles/ctlr/create';
import edit  from 'belt/core/js/roles/ctlr/edit';

export default [
    {path: '/roles', component: index, canReuse: false, name: 'roles'},
    {path: '/roles/create', component: create, name: 'roles.create'},
    {path: '/roles/edit/:id', component: edit, name: 'roles.edit'},
    {path: '/self', component: edit, name: 'roles.self'},
]