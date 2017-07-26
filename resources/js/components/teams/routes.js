import index from 'belt/core/js/components/teams/ctlr/index';
import create from 'belt/core/js/components/teams/ctlr/create';
import edit  from 'belt/core/js/components/teams/ctlr/edit';
import users  from 'belt/core/js/components/teams/ctlr/users';

export default [
    {path: '/teams', component: index, canReuse: false, name: 'teams'},
    {path: '/teams/create', component: create, name: 'teams.create'},
    {path: '/teams/edit/:id', component: edit, name: 'teams.edit'},
    {path: '/teams/edit/:id/users', component: users, name: 'teams.users'},
]