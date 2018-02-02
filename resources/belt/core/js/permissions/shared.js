export default {
    props: {
        'storeKey': {
            default: function () {
                return this.$parent.storeKey;
            }
        },
    },
    computed: {
        permissions() {
            return this.$store.getters[this.storeKey + '/permissions/data'];
        },
    },
}