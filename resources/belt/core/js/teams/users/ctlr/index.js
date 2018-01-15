import TeamForm from 'belt/core/js/teams/form';
import Form from 'belt/core/js/teams/users/form';
import Table from 'belt/core/js/teams/users/table';
import html from 'belt/core/js/teams/users/templates/index.html';

export default {
    data() {
        return {
            detached: new Table({
                morphable_type: this.$parent.morphable_type,
                morphable_id: this.$parent.morphable_id,
                query: {not: 1},
            }),
            table: new Table({
                morphable_type: this.$parent.morphable_type,
                morphable_id: this.$parent.morphable_id,
            }),
            form: new Form({
                morphable_type: this.$parent.morphable_type,
                morphable_id: this.$parent.morphable_id,
            }),
            team: new TeamForm(),
        }
    },
    mounted() {
        this.table.index();
        this.team.show(this.$parent.morphable_id);
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
    template: html
}