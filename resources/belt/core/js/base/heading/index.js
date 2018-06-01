import html from 'belt/core/js/base/heading/template.html';

export default {

    props: {
        morphable_id: {
            default: function () {
                return this.$parent.morphable_id;
            }
        },
        morphable_type: {
            default: function () {
                return this.$parent.morphable_type;
            }
        },
    },
    computed: {
        team() {
            return _.get(window, 'larabelt.activeTeam');
        },
        isSuper() {
            return _.get(window, 'larabelt.auth.super');
        },
    },
    components: {

    },
    template: html
}