import workRequests from 'belt/core/js/work-requests/list-by-workable';
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
    components: {
        workRequests,
    },
    template: html
}