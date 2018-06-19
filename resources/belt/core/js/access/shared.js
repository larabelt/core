export default {
    computed: {
        authAccess() {
            let data = this.$store.getters['access/data'];
            return _.get(data, 'auth', {});
        }
    },
    methods: {
        authCan(ability, args) {
            this.$store.dispatch('access/can', {
                entity_type: 'users',
                entity_id: '[auth.id]',
                ability: ability,
                args: args
            });
        }
    },
}