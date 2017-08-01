import template from 'belt/core/js/base/dropdown/template.html';

export default {
    props: ['table', 'form', 'column'],
    computed: {
        currentValue() {
            return this.form[this.column];
        },
        showDropdown() {
            return this.table.query.q && this.table.items.length;
        }
    },
    methods: {
        autocomplete(event) {
            if (event.keyCode == 27) {
                return this.reset();
            }
            this.table.query.q = this.currentValue;
            this.table.index();
        },
        reset() {
            this.table.query.q = null;
            this.table.items = [];
        },
        setValue(value) {
            this.form[this.column] = value;
            this.reset();
        },
    },
    template: template
}