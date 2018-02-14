import Form from 'belt/core/js/teams/form';
import edit from 'belt/core/js/teams/edit/shared';
import form_html from 'belt/core/js/teams/edit/form.html';

export default {
    mixins: [edit],
    components: {
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
}