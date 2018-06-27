import Table from 'belt/core/js/search/table';
import html from 'belt/core/js/search/template.html';

export default {
    props: {
        'type': {
            default: function () {
                return '';
            },
        }
    },
    data() {
        return {
            table: new Table(),
        }
    },
    mounted() {
        this.table.updateQuery({type: this.type});
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