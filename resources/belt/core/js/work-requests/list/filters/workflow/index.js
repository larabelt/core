import filter from 'belt/core/js/inputs/filter-base';
import Table from 'belt/core/js/work-requests/table';
import html from 'belt/core/js/work-requests/list/filters/type/template.html';

export default {
    mixins: [filter],
    props: {},
    data() {
        return {
            groupedItems: new Table(),
            workflow_key: null,
        }
    },
    computed: {
        options() {
            let options = {
                '': '',
            };
            let items = _.uniqBy(this.groupedItems.items, 'workflow_key');
            items = _.sortBy(items, [function (o) {
                return o.workflow_key ? o.workflow_key : 1;
            }]);
            _.forEach(items, (item) => {
                options[item.workflow_key] = item.workflow_key;
            });
            return options;
        },
        show() {
            return _.size(this.options) > 2;
        }
    },
    mounted() {
        this.groupedItems.updateQuery({
            groupBy: 'work_requests.workflow_key',
        });
        this.groupedItems.index();
    },
    watch: {
        'table.query.workflow_key': function (workflow_key) {
            if (workflow_key) {
                this.workflow_key = workflow_key;
            }
        }
    },
    methods: {
        change() {
            //this.table.updateQuery({workflow_key: null});
            delete this.table.query.workflow_key;
            if (this.workflow_key) {
                this.table.updateQuery({workflow_key: this.workflow_key});
            }
            this.$emit('filter-workflow-update');
        },
    },
    template: html
}