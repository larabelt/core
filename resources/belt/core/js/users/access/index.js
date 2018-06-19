import shared from 'belt/core/js/users/ctlr/shared';

import user from 'belt/core/js/users/store/mixin';
import assignedRoles from 'belt/core/js/assigned-roles/list';
import heading_html from 'belt/core/js/templates/heading.html';
import tabs_html from 'belt/core/js/users/templates/tabs.html';
import access_html from 'belt/core/js/users/access/template.html';
import html from 'belt/core/js/users/templates/edit.html';

export default {
    mixins: [shared],
    data() {
        return {
            morphable_type: 'users',
            morphable_id: this.$route.params.id,
        }
    },
    components: {
        heading: {template: heading_html},
        tabs: {template: tabs_html},
        edit: {
            mixins: [user],
            data() {
                return {
                    morphable_type: this.$parent.morphable_type,
                    morphable_id: this.$parent.morphable_id,
                    user_id: this.$route.params.id,
                }
            },
            mounted() {
                this.$store.dispatch(this.storeKey + '/roles/load');
            },
            components: {
                assignedRoles,
            },
            template: access_html,
        },
    },
    template: html
}