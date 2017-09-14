import debounce from 'debounce';
import base from 'belt/core/js/inputs/filter-base';
import html from 'belt/core/js/inputs/filter-search/template.html';

export default {
    mixins: [base],
    data() {
        return {
            needle: '',
        };
    },
    watch: {
        'table.query.q': function (new_needle) {
            if (new_needle) {
                this.needle = new_needle;
            }
        }
    },
    methods: {
        filter: debounce(function () {
            this.$emit('filter-search-update', {page: 1, q: this.needle});
        }, 250),
        clear() {
            this.needle = '';
            this.$emit('filter-search-update', {q: ''});
        },
    },
    template: html
}