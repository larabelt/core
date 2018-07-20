import base from 'belt/core/js/filters/base';
import html from 'belt/core/js/filters/search/template.html';

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
        filter: _.debounce(function (query) {
            this.$emit('filter-search-update', {page: 1, q: this.needle});
        }, 750),
        clear() {
            this.needle = '';
            this.$emit('filter-search-update', {q: ''});
        },
    },
    template: html
}