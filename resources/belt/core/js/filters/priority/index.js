import html from 'belt/core/js/filters/priority/template.html';

export default {
    props: {
        table: {
            default: function () {
                return this.$parent.table;
            }
        },
        options: {
            default: function () {
                return [
                    0,
                    1,
                    2,
                    3,
                    4,
                    5,
                    6,
                    7,
                    8,
                    9,
                    10,
                ]
            }
        }
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