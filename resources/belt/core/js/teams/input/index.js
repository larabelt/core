import debounce from 'debounce';
import list from 'belt/core/js/teams/list';
import Form from 'belt/core/js/teams/form';
import Table from 'belt/core/js/teams/table';
import html from 'belt/core/js/teams/input/template.html';

export default {
    props: ['form'],
    data() {
        return {
            team: new Form(),
            search: false,
            table: new Table(),
        }
    },
    watch: {
        'form.team_id': function (new_team_id) {
            if (new_team_id) {
                this.team.show(new_team_id);
            }
        }
    },
    methods: {
        filter: debounce(function () {
            this.table.index();
        }),
        toggle() {
            if (!this.search) {
                this.table.index();
            }
            this.search = !this.search;
        },
        clear() {
            this.form.team_id = null;
            this.team.reset();
            this.search = false;
        },
        setTeam(team) {
            this.form.team_id = team.id;
            this.team.setData(team);
            this.search = false;
        }
    },
    components: {
        list
    },
    template: html
}