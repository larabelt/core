import access from 'belt/core/js/access/shared';

// helpers
import Form from 'belt/core/js/users/form';

// templates make a change
import tabs_html from 'belt/core/js/users/templates/tabs.html';
import edit_html from 'belt/core/js/users/templates/edit.html';
import form_html from 'belt/core/js/users/templates/form.html';

export default {
    mixins: [access],
    data() {
        this.authCan('attach', 'roles');
        return {
            form: new Form(),
            morphable_type: 'users',
            morphable_id: this.$route.params.id,
        }
    },
    mounted() {
        this.form.show(this.morphable_id);
    },
    computed: {
        authCanAttachRoles() {
            return _.get(this.authAccess, 'roles.attach');
        }
    },
    components: {
        tabs: {template: tabs_html},
        edit: {
            data() {
                return {
                    form: this.$parent.form,
                }
            },
            template: form_html,
        },
    },
    template: edit_html,
}