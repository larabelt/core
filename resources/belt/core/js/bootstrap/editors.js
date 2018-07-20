import tinymce from 'belt/core/js/editors/tinymce.vue';
import codemirror from 'belt/core/js/editors/codemirror.vue';
import textarea from 'belt/core/js/editors/textarea.vue';

switch (process.env.MIX_LARABELT_EDITOR) {
    case 'codemirror':
        Vue.component('belt-editor', codemirror);
        break;
    case 'tinymce':
        Vue.component('belt-editor', tinymce);
        break;
    default:
        Vue.component('belt-editor', textarea);
}