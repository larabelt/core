import Table from 'belt/core/js/search/table';
import html from 'belt/core/js/search/template.html';

export default {
    data() {
        return {
            table: new Table(),
        }
    },
    methods: {
        attach(item) {
            this.$emit('attach-search-item', item);
        },
        clear() {
            this.table.query.q = '';
            this.$emit('clear-search-items');
        },
    },
    template: html
}