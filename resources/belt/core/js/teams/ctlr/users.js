// components
import users from 'belt/core/js/teams/users/ctlr/index';

// templates
import heading_html from 'belt/core/js/templates/heading.html';
import tabs_html from 'belt/core/js/teams/templates/tabs.html';
import edit_html from 'belt/core/js/teams/templates/edit.html';

export default {
    data() {
        return {
            morphable_type: 'teams',
            morphable_id: this.$route.params.id,
        }
    },
    components: {
        heading: {template: heading_html},
        tabs: {template: tabs_html},
        edit: users,
    },
    mounted() {

    },
    methods: {

    },
    template: edit_html
}