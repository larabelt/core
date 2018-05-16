import team from 'belt/core/js/teams/store/mixin';
import Form from 'belt/core/js/teams/form';
import edit from 'belt/core/js/teams/edit/shared';
import html from 'belt/core/js/teams/edit/form.html';

export default {
    mixins: [edit],
    components: {
        edit: {
            mixins: [team],
            data() {
                return {
                    morphable_type: 'teams',
                    morphable_id: this.$parent.morphable_id,
                    team_id: this.$parent.morphable_id,
                }
            },
            computed: {
                form() {
                    return this.$parent.team;
                }
            },
            template: html,
        },
    },
}