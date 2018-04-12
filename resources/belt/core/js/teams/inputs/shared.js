import Table from 'belt/core/js/teams/table';
import html from 'assets/js/admin/leads/shared/team-dropdown/template.html';

export default {
    data() {
        return {
            teams: new Table(),
            team_id: null,
        }
    },
    computed: {
        options() {
            let options = []
            options.push({
                value: null,
                label: '',
            });
            let items = _.sortBy(this.teams.items, 'name');
            _.forEach(items, (item) => {
                options.push({
                    value: item.id,
                    label: item.name,
                })
            });
            return options;
        },
    },
    mounted() {
        this.teams.updateQuery({perPage: 99999});
        this.teams.index();
    },
    template: html
}