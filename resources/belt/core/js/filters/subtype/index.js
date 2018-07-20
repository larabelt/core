import base from 'belt/core/js/filters/base';
import shared from 'belt/core/js/subtypes/shared';
import html from 'belt/core/js/filters/subtype/template.html';

export default {
    mixins: [base, shared],
    props: {
        table: {
            default: function () {
                return this.$parent.table;
            }
        },
    },
    data() {
        return {
            subtype: null,
        }
    },
    watch: {
        'table.query.subtype': function (subtype) {
            if (subtype) {
                this.subtype = subtype;
            }
        }
    },
    methods: {
        change() {
            this.table.query.subtype = this.subtype;
            this.$emit('filter-subtype-update');
        },
    },
    template: html
}