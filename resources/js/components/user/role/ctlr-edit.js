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
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Roles</h3>
                </div>
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <role-index></role-index>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `
}