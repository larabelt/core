import mixin from 'belt/core/js/assigned-roles/list/mixin';
import roles from 'belt/core/js/roles/list/mixin';
import rowItem from 'belt/core/js/assigned-roles/list/row-item';
import html from 'belt/core/js/assigned-roles/list/template.html';

export default {
    mixins: [mixin, roles],
    mounted() {
        this.$store.dispatch('roles/load');
    },
    components: {
        rowItem
    },
    template: html
}