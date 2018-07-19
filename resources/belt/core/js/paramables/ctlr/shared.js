export default {
    beforeCreate() {
        this.entity_type = this.$parent.entity_type;
        this.entity_id = this.$parent.entity_id;
    },
}