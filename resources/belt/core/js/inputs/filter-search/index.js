import debounce from 'debounce';
import base from 'belt/core/js/inputs/filter-base';
import html from 'belt/core/js/inputs/filter-search/template.html';

export default {
    mixins: [base],
    props: {
        //table: {default: null},
        //form: {default: null},
    },
    data() {
        return {};
    },
    computed: {
        showClear() {
            return this.table.query.q;
        }
    },
    created() {

    },
    methods: {
        filter: debounce(function () {
            this.table.query.page = 1;
            this.table.index();
            this.history();
        }, 250),
        clear() {
            this.table.query.q = '';
            this.table.index();
            this.history();
        },
        history() {
            if (this.table.name) {
                History.set(this.table.name, 'table.query.page', 1);
                History.set(this.table.name, 'table.query.q', this.table.query.q);
            }
        }
    },
    template: html
}