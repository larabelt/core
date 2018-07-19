import html from 'belt/core/js/base/heading/template.html';

export default {

    props: {
        entity_id: {
            default: function () {
                return this.$parent.entity_id;
            }
        },
        entity_type: {
            default: function () {
                return this.$parent.entity_type;
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