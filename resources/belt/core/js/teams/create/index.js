import Form from 'belt/core/js/teams/form';

import form_html from 'belt/core/js/teams/create/form.html';
import create_html from 'belt/core/js/teams/create/template.html';

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