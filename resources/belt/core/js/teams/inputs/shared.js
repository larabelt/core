import store from 'belt/core/js/teams/inputs/store';

export default {
    data() {
        return {
            team_id: null,
        }
    },
    created() {
        if (!this.$store.state['teams']) {
            this.$store.registerModule('teams', store);
            this.$store.dispatch('teams/load');
        }
    },
    computed: {
        teams() {
            return this.$store.getters['teams/data'];
        },
        options() {
            let options = []
            options.push({
                value: null,
                label: '',
            });
            let items = _.sortBy(this.teams, 'name');
            _.forEach(items, (item) => {
                options.push({
                    value: item.id,
                    label: item.name,
                })
            });
            return options;
        },
    },
}