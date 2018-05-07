import list from 'belt/core/js/roles/list';
import create from 'belt/core/js/roles/create';
import edit  from 'belt/core/js/roles/edit';
import access  from 'belt/core/js/roles/access';

export default [
    {path: '/roles', component: list, canReuse: false, name: 'roles'},
    {path: '/roles/create', component: create, name: 'roles.create'},
    {path: '/roles/edit/:id', component: edit, name: 'roles.edit'},
    {path: '/roles/edit/:id/access', component: access, name: 'roles.access'},
]