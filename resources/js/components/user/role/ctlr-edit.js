import roleService from './service';
import roleIndexTemplate from './templates/index';

export default {
    data() {
        return {
            user_id: this.$parent.morphable_id,
        }
    },
    components: {
        'role-index': {
            mixins: [roleService],
            template: roleIndexTemplate,
            data() {
                return {
                    user_id: this.$parent.user_id,
                }
            },
            mounted() {
                this.paginate();
                this.paginateAll();
            },
        },
    },
    template: `
        <div>
            <role-index></role-index>
        </div>
        `
}