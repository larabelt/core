
// helpers
import Form from '../form';

// templates make a change
import heading_html from 'belt/core/js/templates/heading.html';
import tabs_html from '../templates/tabs.html';
import edit_html from '../templates/edit.html';
import form_html from '../templates/form.html';

export default {
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