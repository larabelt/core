// helpers
import Form from 'belt/core/js/alerts/form';

// templates make a change

import form_html from 'belt/core/js/alerts/templates/form.html';
import create_html from 'belt/core/js/alerts/templates/create.html';

export default {
    components: {

        create: {
            data() {
                return {
                    form: new Form({router: this.$router}),
                }
            },
            template: form_html,
        },
    },
    template: create_html
}