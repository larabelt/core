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
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Users</h3>
                </div>
                <div class="box box-primary">
                    <div class="box-body">
                        <user-index></user-index>
                    </div>
                </div>
            </div>
        </div>
        `
}