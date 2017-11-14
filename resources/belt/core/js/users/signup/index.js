import Form from 'belt/core/js/users/signup/form';
import html from 'belt/core/js/users/signup/template.html';

export default {
    props: {
        redirect: {
            default: '/users/welcome'
        }
    },
    data() {
        return {
            form: new Form(),
        }
    },
    methods: {
        submit() {
            this.form.submit()
                .then(() => {
                    window.location.replace(this.redirect);
                });
        }
    },
    template: html,
}