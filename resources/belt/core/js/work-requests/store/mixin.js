import store from 'belt/core/js/work-requests/store';

export default {
    created() {
        if (!this.$store.state[this.storeKey]) {
            this.$store.registerModule(this.storeKey, store);
        }
    },
    computed: {
        availableTransitions() {
            let available = {};
            _.forEach(this.transitions, (transition, property) => {
                if (_.get(transition, 'from') == this.place) {
                    available[property] = transition;
                }
            });
            return available;
        },
        storeKey() {
            return 'workRequests' + this.work_request_id;
        },
        place() {
            return this.workRequest.place;
        },
        places() {
            return _.get(this.workflow, 'places', {});
        },
        transitions() {
            return _.get(this.workflow, 'transitions', {});
        },
        workflow() {
            return _.get(this.workRequest, 'workflow', {
                name: '',
                label: '',
            });
        },
        workRequest() {
            return this.$store.getters[this.storeKey + '/form'];
        },
    },
    methods: {
        humanize(str) {
            str = _.replace(str, '-', ' ');
            str = _.replace(str, '_', ' ');
            return str;
        }
    }
}