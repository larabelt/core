import Table from 'belt/core/js/components/paramables/table';
import Form from 'belt/core/js/components/paramables/form';
import shared from 'belt/core/js/components/paramables/ctlr/shared';
import html from 'belt/core/js/components/paramables/templates/edit.html';

export default {
    mixins: [shared],
    props: [
        'param'
    ],
    data() {
        return {
            detached: new Table({
                morphable_type: this.morphable_type,
                morphable_id: this.morphable_id,
                query: {not: 1},
            }),
            table: this.$parent.table,
            form: new Form({
                morphable_type: this.morphable_type,
                morphable_id: this.morphable_id,
            }),
        }
    },
    mounted() {
        this.form.show(this.param.id);
    },
    methods: {
        update() {
            this.form.submit()
                .then(() => {
                    this.table.index();
                    //this.form.reset();
                });
        }
    },
    template: html
}