import Form from 'belt/core/js/work-requests/form';
import action from 'belt/core/js/work-requests/list-workable/list-item/action';
import html from 'belt/core/js/work-requests/list-workable/list-item/template.html';

export default {
    props: {
        workRequest: {},
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
        return {
            form: new Form(),
        }
    },
    computed: {
        availableTransitions() {

            let available = {};
            _.forEach(this.transitions, (transition, property) => {
                if (_.get(transition, 'from') == this.workRequest.place) {
                    available[property] = transition;
                }
            });

            return available;
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
        workflowName() {
            return this.humanize(this.workflow.name);
        },
    },
    methods: {
        humanize(str) {
            str = _.replace(str, '-', ' ');
            str = _.replace(str, '_', ' ');
            return str;
        }
    },
    mounted() {
        this.form.setData(this.workRequest);
    },
    components: {
        action,
    },
    template: html,
}