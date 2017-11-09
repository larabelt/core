import shared from 'belt/core/js/inputs/priority/shared';
import html from 'belt/core/js/inputs/priority/filter/template.html';

export default {
    mixins: [shared],
    props: {
        table: {
            default: function () {
                return this.$parent.table;
            }
        },
    },
    data() {
        return {
            priority: 0,
        }
    },
    watch: {
        'table.query.priority': function (priority) {
            if (priority) {
                this.priority = priority;
            }
        }
    },
    methods: {
        change() {
            this.table.query.priority = this.priority;
            this.$emit('filter-priority-update');
        },
    },
    template: html
}