import tabs_html from 'belt/core/js/teams/edit/tabs.html';
import html from 'belt/core/js/teams/edit/template.html';

export default {
    data() {
        return {
            morphable_type: 'teams',
            morphable_id: this.$route.params.id,
        }
    },
    components: {
        tabs: {template: tabs_html},
        edit: {},
    },
    template: html,
}