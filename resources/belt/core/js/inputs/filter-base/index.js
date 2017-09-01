import html from 'belt/core/js/inputs/filter-base/template.html';

export default {
    data() {
        return {
            table: this.$parent.table ? this.$parent.table : null,
            events: this.$parent.events,
        };
    },
    computed: {},
    created() {

    },
    methods: {},
    template: html,
}