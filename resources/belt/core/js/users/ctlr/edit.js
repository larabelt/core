import shared from 'belt/core/js/users/ctlr/shared';

// helpers
import Form from 'belt/core/js/users/form';

// templates make a change
import heading_html from 'belt/core/js/templates/heading.html';
import tabs_html from 'belt/core/js/users/templates/tabs.html';
import edit_html from 'belt/core/js/users/templates/edit.html';
import form_html from 'belt/core/js/users/templates/form.html';

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