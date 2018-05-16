import store from 'belt/core/js/users/store';

export default {
    created() {
        if (!this.$store.state[this.storeKey]) {
            this.$store.registerModule(this.storeKey, store);
            this.$store.dispatch(this.storeKey + '/load', this.user_id);
        }
    },
    computed: {
        abilities() {
            return this.$store.getters[this.storeKey + '/abilities/data'];
        },

        form() {
            return this.user;
        },
        user() {
            return this.$store.getters[this.storeKey + '/form'];
        },
        roles() {
            return this.$store.getters[this.storeKey + '/roles/data'];
        },
        storeKey() {
            return 'users' + this.user_id;
        },
    },
    data() {
        return {
            user_id: null,
        }
    },
}