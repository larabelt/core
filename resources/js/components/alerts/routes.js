import index from './ctlr/index';
import create from './ctlr/create';
import edit  from './ctlr/edit';

export default [
    {path: '/alerts', component: index, canReuse: false, name: 'alerts'},
    {path: '/alerts/create', component: create, name: 'alerts.create'},
    {path: '/alerts/edit/:id', component: edit, name: 'alerts.edit'},
]