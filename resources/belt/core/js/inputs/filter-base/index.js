import html from 'belt/core/js/inputs/filter-base/template.html';

export default {
    props: {
        router: {
            default: null,
        },
        morphable_type: {
            default: function () {
                return this.$parent.morphable_type;
            }
        },
        morphable_id: {
            default: function () {
                return this.$parent.morphable_id;
            }
        },
        table: {
            default: function () {
                return this.$parent.table;
            }
        },
    },
    data() {
        return {
            //table: this.$parent.table ? this.$parent.table : null,
            events: this.$parent.events,
        };
    },
    template: html,
}