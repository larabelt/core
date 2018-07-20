import html from 'belt/core/js/filters/base/template.html';

export default {
    props: {
        router: {
            default: null,
        },
        entity_type: {
            default: function () {
                return this.$parent.entity_type;
            }
        },
        entity_id: {
            default: function () {
                return this.$parent.entity_id;
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