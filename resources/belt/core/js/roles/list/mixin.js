import store from 'belt/core/js/roles/list/store';

export default {
    created() {
        if (!this.$store.state['roles']) {
            this.$store.registerModule('roles', store);
        }
    },
    computed: {
        roles() {
            return this.$store.getters['roles/data'];
        },
    },
}