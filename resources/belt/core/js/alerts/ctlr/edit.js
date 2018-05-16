// helpers
import Form from 'belt/core/js/alerts/form';

// templates make a change
import heading_html from 'belt/core/js/templates/heading.html';
import edit_html from 'belt/core/js/alerts/templates/edit.html';
import form_html from 'belt/core/js/alerts/templates/form.html';

export default {
    data() {
        return {
            form: new Form(),
            morphable_type: 'alerts',
            morphable_id: this.$route.params.id,
        }
    },
    mounted() {
        this.form.show(this.morphable_id);
    },
    components: {
        heading: {template: heading_html},
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