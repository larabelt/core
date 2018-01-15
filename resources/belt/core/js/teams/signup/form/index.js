import Form from 'belt/core/js/teams/form';
import html from 'belt/core/js/teams/signup/form/template.html';

export default {
    data() {
        return {
            form: new Form(),
        }
    },
    methods: {
        submit() {
            let auth = _.get(window, 'larabelt.auth.email');
            this.form.default_user_id = auth ? '[auth.id]' : this.$parent.user.id;
            this.form.submit()
                .then((response) => {
                    this.$emit('team-signup-success', response);
                });
        }
    },
    template: html,
}