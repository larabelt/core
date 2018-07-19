// helpers
import Form from 'belt/core/js/users/roles/form';
import Table from 'belt/core/js/users/roles/table';

// templates
import index_html from 'belt/core/js/users/roles/templates/index.html';

export default {
    data() {
        return {
            detached: new Table({
                entity_type: this.$parent.entity_type,
                entity_id: this.$parent.entity_id,
                query: {not: 1},
            }),
            table: new Table({
                entity_type: this.$parent.entity_type,
                entity_id: this.$parent.entity_id,
            }),
            form: new Form({
                entity_type: this.$parent.entity_type,
                entity_id: this.$parent.entity_id,
            }),
        }
    },
    mounted() {
        this.table.index();
    },
    methods: {
        attach(id) {
            this.form.setData({id: id});
            this.form.store()
                .then(response => {
                    this.table.index();
                    this.detached.index();
                })
        },
        clear() {
            this.detached.query.q = '';
        },
    },
    template: index_html
}