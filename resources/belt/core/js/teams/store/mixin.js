import Form from 'belt/core/js/teams/form';
import store from 'belt/core/js/teams/store';

export default {
    created() {
        if (!this.$store.state[this.storeKey]) {
            this.$store.registerModule(this.storeKey, store);
            this.$store.dispatch(this.storeKey + '/load', this.team_id);
        }
    },
    computed: {
        storeKey() {
            return 'teams' + this.team_id;
        },
        team() {
            return this.$store.getters[this.storeKey + '/form'];
        },
        roles() {
            return this.$store.getters[this.storeKey + '/roles/data'];
        },
    },
    methods: {

    },
    data() {
        return {
            team_id: null,
        }
    },
}