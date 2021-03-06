import user from 'belt/core/js/users/store/mixin';
import assignedRoles from 'belt/core/js/assigned-roles/list';
import tabs_html from 'belt/core/js/users/templates/tabs.html';
import access_html from 'belt/core/js/users/access/template.html';
import html from 'belt/core/js/users/templates/edit.html';

export default {
    mixins: [user],
    data() {
        return {
            entity_type: 'users',
            entity_id: this.$route.params.id,
            user_id: this.$route.params.id,
        }
    },
    mounted() {
        this.$store.dispatch(this.storeKey + '/roles/load');
    },
    components: {
        tabs: {template: tabs_html},
        edit: {
            data() {
                return {
                    entity_type: this.$parent.entity_type,
                    entity_id: this.$parent.entity_id,
                    user_id: this.$parent.entity_id,
                    storeKey: this.$parent.storeKey,
                }
            },
            components: {
                assignedRoles,
            },
            template: access_html,
        },
    },
    template: html
}