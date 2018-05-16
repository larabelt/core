// helpers
import Form from 'belt/core/js/roles/form';

// templates make a change

import form_html from 'belt/core/js/roles/create/form.html';
import html from 'belt/core/js/roles/create/template.html';

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
    template: html
}