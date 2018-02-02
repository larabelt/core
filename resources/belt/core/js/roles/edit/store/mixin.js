import store from 'belt/core/js/roles/edit/store';

export default {
    beforeCreate() {
        this.$store.dispatch('abilities/construct');
    },
    data() {
        return {
            role_id: null,
        }
    },
    created() {
        if (!this.$store.state[this.storeKey]) {
            this.$store.registerModule(this.storeKey, store);
            this.$store.dispatch(this.storeKey + '/load', this.role_id);
        }
    },
    computed: {
        storeKey() {
            if (this.role_id) {
                return 'roles' + this.role_id;
            }
        },
        role() {
            return this.$store.getters[this.storeKey + '/form'];
        },
        permissions() {
            return this.$store.getters[this.storeKey + '/permissions/data'];
        },
    },
}