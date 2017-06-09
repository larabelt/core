import Form from 'belt/core/js/components/paramables/form';
import ParamKeyTable from 'belt/core/js/components/param-keys/table';
import ParamValaueTable from 'belt/core/js/components/param-values/table';
import shared from 'belt/core/js/components/paramables/ctlr/shared';
import html from 'belt/core/js/components/paramables/templates/create.html';

export default {
    mixins: [shared],
    data() {
        return {
            table: this.$parent.table,
            paramKeys: new ParamKeyTable(),
            paramValues: new ParamValaueTable(),
            form: new Form({
                morphable_type: this.morphable_type,
                morphable_id: this.morphable_id,
            }),
        }
    },
    mounted() {
        this.paramValues.query.key = this.form.key;
    },
    methods: {
        create() {
            this.form.submit()
                .then(() => {
                    this.table.index();
                    this.form.reset();
                });
        },
        setValue(value) {
            this.form.value = value;
            this.paramValues.query.q = null;
            this.paramValues.items = [];
        },
        values() {
            this.paramValues.query.q = this.form.value;
            this.paramValues.index();
        },
    },
    template: html
}