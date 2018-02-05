import list from 'belt/core/js/teams/list';
import create from 'belt/core/js/teams/create';
import edit  from 'belt/core/js/teams/edit';
import users  from 'belt/core/js/teams/edit/users';
import related  from 'belt/core/js/teams/edit/related';

export default [
    {path: '/teams', component: list, canReuse: false, name: 'teams'},
    {path: '/teams/create', component: create, name: 'teams.create'},
    {path: '/teams/edit/:id', component: edit, name: 'teams.edit'},
    {path: '/teams/edit/:id/users', component: users, name: 'teams.users'},
    {path: '/teams/edit/:id/related', component: related, name: 'teams.related'},
]