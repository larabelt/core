export default {
    data() {
        return {
            form: this.$parent.form,
            morphable_type: 'teams',
            morphable_id: this.$parent.morphable_id,
            team_id: this.$parent.morphable_id,
            team: this.$parent.team,
        }
    },
}