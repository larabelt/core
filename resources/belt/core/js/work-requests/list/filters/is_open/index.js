import filter from 'belt/core/js/inputs/filter-base';
import Table from 'belt/core/js/work-requests/table';
import html from 'belt/core/js/work-requests/list/filters/is_open/template.html';

export default {
    mixins: [filter],
    data() {
        return {
            is_open: null,
            options: {
                '': null,
                'Yes': 1,
                'No': 0,
            },
        }
    },
    mounted() {
        this.table.updateQueryFromRouter();
        this.is_open = this.table.query.is_open;
    },
    methods: {
        change() {
            delete this.table.query.is_open;
            if (this.is_open === 1 || this.is_open === 0) {
                this.table.updateQuery({is_open: this.is_open});
            }
            this.$emit('filter-is_open-update');
        },
    },
    template: html
}