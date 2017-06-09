import Form from 'belt/core/js/components/paramables/form';
import Table from 'belt/core/js/components/paramables/table';
import shared from 'belt/core/js/components/paramables/ctlr/shared';
import create from 'belt/core/js/components/paramables/ctlr/create';
import edit from 'belt/core/js/components/paramables/ctlr/edit';
import html from 'belt/core/js/components/paramables/templates/index.html';

export default {
    mixins: [shared],
    data() {
        return {
            detached: new Table({
                morphable_type: this.morphable_type,
                morphable_id: this.morphable_id,
                query: {not: 1},
            }),
            table: new Table({
                morphable_type: this.morphable_type,
                morphable_id: this.morphable_id,
            }),
        }
    },
    mounted() {
        this.table.index();
    },
    methods: {

    },
    components: {
        create: create,
        edit: edit,
    },
    template: html
}