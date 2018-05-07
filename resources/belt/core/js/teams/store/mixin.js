import Form from 'belt/core/js/teams/form';
import store from 'belt/core/js/teams/store';

export default {
    created() {
        if (!this.$store.state[this.storeKey]) {
            this.$store.registerModule(this.storeKey, store);
        }
    },
    computed: {
        storeKey() {
            return 'teams' + this.team_id;
        },
        team() {
            return this.$store.getters[this.storeKey + '/form'];
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