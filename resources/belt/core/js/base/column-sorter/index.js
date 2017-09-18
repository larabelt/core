import html from 'belt/core/js/base/column-sorter/template.html';

export default {

    props: {
        column: String,
    },
    data() {
        return {
            'table': this.$parent.table,
        };
    },
    computed: {
        asc() {
            return !this.active || this.orderBy.substr(0, 1) != '-';
        },
        active() {
            return this.column == this.activeColumn;
        },
        activeColumn() {
            return _.trimStart(this.orderBy, '-');
        },
        orderBy() {
            return this.table ? this.table.getQuery('orderBy') : '';
        },
        show() {
            return this.table != undefined && this.table.total > 1;
        },
        title() {
            if (this.active && !this.asc) {
                return 'reverse sort by ' + this.column;
            }

            return 'sort by ' + this.column;
        },
        toggle() {
            return this.active && this.asc ? '-' + this.column : this.column;
        }
    },
    methods: {
        paginate() {
            this.table.updateQuery(this.query());
            this.table.index();
            if (this.table.router) {
                this.table.router.push({query: this.table.getQuery()});
            }
            if (this.table.name) {
                History.set(this.table.name, 'table.query.orderBy', this.table.query.orderBy);
                History.set(this.table.name, 'table.query.sortBy', this.table.query.sortBy);
                History.set(this.table.name, 'table.query.page', this.table.query.page);
            }
        },
        query() {
            return {
                orderBy: this.toggle,
                sortBy: '',
                page: 1
            };
        },
    },

    template: html,
}