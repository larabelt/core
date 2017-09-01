import base from 'belt/core/js/inputs/filter-base';
import html from 'belt/core/js/inputs/filter-set/template.html';

export default {
    props: {
        table: {default: null},
        form: {default: null},
    },
    data() {
        return {
            events: new Vue(),
        };
    },
    computed: {

    },
    created() {

    },
    methods: {

    },
    components: {
        slot1: base,
        slot2: base,
        slot3: base,
        results1: base,
        results2: base,
        results3: base,
    },
    template: html
}