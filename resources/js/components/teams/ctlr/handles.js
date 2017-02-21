// components
import handles from 'belt/content/js/components/handleables/ctlr/index';

// templates
import heading_html from 'belt/core/js/templates/heading.html';
import tabs_html from '../templates/tabs.html';
import edit_html from '../templates/edit.html';

export default {
    data() {
        return {
            morphable_type: 'teams',
            morphable_id: this.$route.params.id
        }
    },
    components: {
        heading: {template: heading_html},
        tabs: {template: tabs_html},
        edit: handles,
    },
    template: edit_html,
}