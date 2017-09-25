export default {
    beforeCreate() {
        this.morphable_type = this.$parent.morphable_type;
        this.morphable_id = this.$parent.morphable_id;
    },
}