import mixin from 'belt/core/js/assigned-roles/list/mixin';
import roles from 'belt/core/js/roles/list/mixin';
import row from 'belt/core/js/assigned-roles/list/row';
import html from 'belt/core/js/assigned-roles/list/template.html';

export default {
    mixins: [mixin, roles],
    props: ['storeKey'],
    mounted() {
        this.$store.dispatch('roles/load');
    },
    components: {
        row
    },
    template: html
}