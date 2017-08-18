import html from 'belt/core/js/base/heading/template.html';

export default {

    props: {
        // table: {default: null},
    },
    data() {
        return {};
    },
    computed: {
        team() {
            return _.get(window, 'larabelt.activeTeam');
        }
    },
    created() {


    },
    methods: {},
    template: html
}