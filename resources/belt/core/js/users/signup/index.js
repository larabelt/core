import userForm from 'belt/core/js/users/signup/form';
import html from 'belt/core/js/users/signup/template.html';

export default {
    props: {
        redirect: {
            default: '/users/welcome'
        },
        label_is_opted_in: {
            default: 'Yes! Sign me up for the occasional update.'
        },
        label_submit_button: {
            default: 'Sign Up'
        },
    },
    methods: {
        submit() {
            if (this.redirect) {
                window.location.replace(this.redirect);
            }
        }
    },
    components: {
        userForm
    },
    template: html,
}