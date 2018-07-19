// components
import roles from 'belt/core/js/roles2';

// templates

import tabs_html from 'belt/core/js/users/templates/tabs.html';
import edit_html from 'belt/core/js/users/templates/edit.html';

export default {
    data() {
        return {
            entity_type: 'users',
            entity_id: this.$route.params.id,
        }
    },
    components: {

        tabs: {template: tabs_html},
        edit: roles,
    },
    template: edit_html
}