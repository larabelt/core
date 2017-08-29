import html from 'belt/core/js/base/pagination/template.html';

export default {
    data() {
        return {
            max: 5,
            table: this.$parent.table,
            perPages: {
                10: 10,
                50: 50,
                100: 100,
                500: 500,
                1000: 1000,
            }
        }
    },
    computed: {
        show() {
            if (this.table == undefined || this.table.length == 0) {
                return false;
            }

            return this.table.total > 50 || this.table.total > this.table.per_page;
        },
        perPage() {
            return this.table.per_page ? this.table.per_page : 13;
        },
        isNotFirst() {
            return this.table.current_page != 1
        },
        hasNext() {
            return this.table.last_page - this.table.current_page > 0;
        },
        indexes() {

            let first = this.table.current_page;

            let values = [];

            let midpoint = Math.ceil(this.max / 2);

            if (this.table.last_page - this.max > 0) {

                if (this.table.current_page >= midpoint) {
                    first = this.table.current_page - (this.max % midpoint);
                }

                if (this.table.last_page - this.table.current_page < midpoint) {
                    first = this.table.last_page - (this.max - 1)
                }
            }

            if (this.table.last_page - this.max <= 0) {
                first = 1;
                this.max = this.table.last_page;
            }

            let i = first;
            while (i < first + this.max) {
                values.push(i);
                i++;
            }

            return values;
        },
        hasPrevious() {
            return this.table.current_page - 1 > 0;
        },
        hasLast() {
            return this.table.current_page != this.table.last_page;
        }
    },
    methods: {
        paginate(query) {
            this.table.updateQuery(query);
            this.table.index();
            if (this.table.router) {
                this.table.router.push({query: this.table.getQuery()});
            }
        },
        isActive(id) {
            return id == this.table.current_page;
        }
    },
    template: html
}