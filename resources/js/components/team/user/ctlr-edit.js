import userService from './service';
import userIndexTemplate from './templates/index';

export default {
    data() {
        return {
            team_id: this.$parent.morphable_id,
        }
    },
    components: {
        'user-index': {
            mixins: [userService],
            template: userIndexTemplate,
            data() {
                return {
                    team_id: this.$parent.team_id,
                }
            },
            mounted() {
                this.paginate();
            },
        },
    },
    template: `
        <div>
            <user-index></user-index>
        </div>
        `
}