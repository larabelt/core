import tabs_html from 'belt/core/js/roles/edit/tabs.html';
import html from 'belt/core/js/roles/edit/template.html';

export default {
    data() {
        return {
            entity_type: 'roles',
            entity_id: this.$route.params.id,
            role_id: this.$route.params.id,
        }
    },
    components: {
        tabs: {template: tabs_html},
    },
    template: html,
}