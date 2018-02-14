import heading_html from 'belt/core/js/templates/heading.html';
import tabs_html from 'belt/core/js/roles/edit/tabs.html';
import html from 'belt/core/js/roles/edit/template.html';

export default {
    data() {
        return {
            morphable_type: 'roles',
            morphable_id: this.$route.params.id,
            role_id: this.$route.params.id,
        }
    },
    components: {
        heading: {template: heading_html},
        tabs: {template: tabs_html},
    },
    template: html,
}