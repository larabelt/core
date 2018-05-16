import team from 'belt/core/js/teams/store/mixin';
import tabs_html from 'belt/core/js/teams/edit/tabs.html';
import html from 'belt/core/js/teams/edit/template.html';

export default {
    mixins: [team],
    data() {
        return {
            morphable_type: 'teams',
            morphable_id: this.$route.params.id,
            team_id: this.$route.params.id,
        }
    },
    mounted() {
        this.$store.dispatch(this.storeKey + '/load', this.team_id);
    },
    components: {
        tabs: {template: tabs_html},
        edit: {},
    },
    template: html,
}