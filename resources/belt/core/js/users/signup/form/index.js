import Form from 'belt/core/js/users/form';
import html from 'belt/core/js/users/signup/form/template.html';

export default {
    data() {
        return {
            form: new Form(),
        }
    },
    computed: {
        emailExists() {
            return this.form.error('email_unique');
        }
    },
    methods: {
        submit() {
            this.form.submit()
                .then((response) => {
                    this.$emit('user-signup-success', response);
                });
        }
    },
    template: html,
}