
// helpers
import Form from 'belt/core/js/components/roles/form';

// templates make a change
import heading_html from 'belt/core/js/templates/heading.html';
import edit_html from 'belt/core/js/components/roles/templates/edit.html';
import form_html from 'belt/core/js/components/roles/templates/form.html';

export default {
    data() {
        return {
            morphable_type: 'roles',
            morphable_id: this.$route.params.id,
        }
    },
    components: {
        heading: {template: heading_html},
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