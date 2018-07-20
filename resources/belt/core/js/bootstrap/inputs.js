import datetime from 'belt/core/js/inputs/datetime';
import editor from 'belt/core/js/inputs/editor';
import params from 'belt/core/js/params/list';
import priority from 'belt/core/js/inputs/priority';
import select from 'belt/core/js/inputs/select';
import subtype from 'belt/core/js/inputs/subtype';
import team from 'belt/core/js/teams/inputs/default';
import text from 'belt/core/js/inputs/text';
import textarea from 'belt/core/js/inputs/textarea';

Vue.component('input-datetime', datetime);
Vue.component('input-editor', editor);
Vue.component('input-params', params);
Vue.component('input-priority', priority);
Vue.component('input-select', select);
Vue.component('input-subtype', subtype);
Vue.component('input-team', team);
Vue.component('input-text', text);
Vue.component('input-textarea', textarea);