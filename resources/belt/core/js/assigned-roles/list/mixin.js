export default {
    props: {
        'storeKey': {
            default: function () {
                return this.$parent.storeKey;
            }
        },
    },
    computed: {
        assignedRoles() {
            return this.$store.getters[this.storeKey + '/roles/data'];
        },
    },
}