import filter from 'belt/core/js/inputs/filter-base';
import Table from 'belt/core/js/work-requests/table';
import html from 'belt/core/js/work-requests/list/filters/type/template.html';

export default {
    mixins: [filter],
    props: {},
    data() {
        return {
            groupedItems: new Table(),
            workable_type: null,
        }
    },
    computed: {
        options() {
            let options = {
                '': '',
            };
            let items = _.uniqBy(this.groupedItems.items, 'workable_type');
            items = _.sortBy(items, [function (o) {
                return o.workable_type ? o.workable_type : 1;
            }]);
            _.forEach(items, (item) => {
                options[item.workable_type] = item.workable_type;
            });
            return options;
        },
        show() {
            return _.size(this.options) > 2;
        }
    },
    mounted() {
        this.groupedItems.updateQuery({
            groupBy: 'work_requests.workable_type',
        });
        this.groupedItems.index();
    },
    watch: {
        'table.query.workable_type': function (workable_type) {
            if (workable_type) {
                this.workable_type = workable_type;
            }
        }
    },
    methods: {
        change() {
            //this.table.updateQuery({workable_type: null});
            delete this.table.query.workable_type;
            if (this.workable_type) {
                this.table.updateQuery({workable_type: this.workable_type});
            }
            this.$emit('filter-workable_type-update');
        },
    },
    template: html
}