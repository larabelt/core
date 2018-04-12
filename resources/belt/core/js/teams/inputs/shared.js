import Table from 'belt/core/js/teams/table';

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
}