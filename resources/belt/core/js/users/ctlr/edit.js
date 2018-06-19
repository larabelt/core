import access from 'belt/core/js/access/shared';

// helpers
import Form from 'belt/core/js/users/form';

// templates make a change
import heading_html from 'belt/core/js/templates/heading.html';
import tabs_html from 'belt/core/js/users/templates/tabs.html';
import edit_html from 'belt/core/js/users/templates/edit.html';
import form_html from 'belt/core/js/users/templates/form.html';

export default {
    mixins: [access],
    data() {
        this.authCan('attach', 'roles');
        return {
            morphable_type: 'users',
            morphable_id: this.$route.params.id,
        }
    },
    computed: {
        authCanAttachRoles() {
            return _.get(this.authAccess, 'roles.attach');
        }
    },
    components: {
        heading: {template: heading_html},
        tabs: {template: tabs_html},
        edit: {
            data() {
                return {
                    form: new Form(),
                }
            },
            mounted() {
                this.form.show(this.$route.params.id);
            },
            template: form_html,
        },
    },
    template: edit_html,
}