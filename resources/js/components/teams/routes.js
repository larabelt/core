import index from './ctlr/index';
import create from './ctlr/create';
import edit  from './ctlr/edit';
//import users  from './ctlr/users';

export default [
    {path: '/teams', component: index, canReuse: false, name: 'teams'},
    {path: '/teams/create', component: create, name: 'teams.create'},
    {path: '/teams/edit/:id', component: edit, name: 'teams.edit'},
    // {path: '/teams/edit/:id/users', component: handles, name: 'teams.users'},
]