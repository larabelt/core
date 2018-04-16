import shared from 'belt/core/js/teams/inputs/shared';
import html from 'belt/core/js/teams/inputs/dropdown/template.html';

export default {
    mixins: [shared],
    props: {
        form: {
            default: () => {
                return this.$parent.form;
            }
        },
        show_label: {
            default: true,
        }
    },
    mounted() {
        this.team_id = this.form.team_id;
    },
    watch: {
        'form.team_id': function (team_id) {
            if (team_id) {
                this.team_id = team_id;
            }
        }
    },
    methods: {
        change() {
            this.form.team_id = this.team_id;
            this.$emit('input-team-update');
        },
    },
    template: html
}