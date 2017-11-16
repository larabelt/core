import teamForm from 'belt/core/js/teams/signup/form';
import userForm from 'belt/core/js/users/signup/form';
import html from 'belt/core/js/teams/signup/template.html';

export default {
    props: {
        redirect: {
            default: '/teams/welcome'
        },
        team_label_submit_button: {
            default: 'Sign Up'
        },
        user_error_msg_email: {
            default: 'This email has already been taken. Please use another email or login.'
        },
        user_label_is_opted_in: {
            default: 'Yes! Sign me up for the occasional update.'
        },
        user_label_submit_button: {
            default: 'Continue'
        },
    },
    data() {
        return {
            auth: {},
            team: {id: null},
            step: 1,
            user: {id: null},
        }
    },
    methods: {
        advance(user) {
            this.step = 2;
            this.user = user;
        },
        complete(team) {
            this.team = team;
            this.step = 3;
            if (this.redirect) {
                window.location.replace(this.redirect);
            }
        },
    },
    mounted() {
        this.auth = _.get(window, 'larabelt.auth.email');
        if (this.auth) {
            this.step = 2;
        }
    },
    components: {
        userForm,
        teamForm,
    },
    template: html,
}