import Table from 'belt/core/js/paramables/table';
import Form from 'belt/core/js/paramables/form';
import shared from 'belt/core/js/paramables/ctlr/shared';
import html from 'belt/core/js/paramables/templates/edit.html';

export default {
    mixins: [shared],
    props: {
        config: {default: {}},
        param: {default: {}},
    },
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
    computed: {
        canDelete() {
            if (!this.config) {
                return true;
            }

            return !_.has(this.config, 'data.params.' + this.param.key)
        },
        options() {
            if (!this.config) {
                return false;
            }
            return _.get(this.config, 'data.params.' + this.param.key, false);
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