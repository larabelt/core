import store from 'belt/core/js/users/store';

export default {
    created() {
        if (!this.$store.state[this.storeKey]) {
            this.$store.registerModule(this.storeKey, store);
            this.$store.dispatch(this.storeKey + '/load', this.user_id);
        }
    },
    computed: {
        storeKey() {
            return 'users' + this.user_id;
        },
        user() {
            return this.$store.getters[this.storeKey + '/form'];
        },
        abilities() {
            return this.$store.getters[this.storeKey + '/abilities/data'];
        },
        roles() {
            return this.$store.getters[this.storeKey + '/roles/data'];
        },
    },
    data() {
        return {
            user_id: null,
        }
    },
}