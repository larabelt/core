import headingTemplate from 'ohio/core/js/templates/base/heading';
import userService from './service';
import userFormTemplate from './templates/form';
import roles from './role/ctlr-edit';

export default {
    data() {
        return {
            morphable_type: 'users',
            morphable_id: this.$route.params.id,
        }
    },
    components: {
        'heading': {
            data() {
                return {
                    title: 'User Editor',
                    subtitle: '',
                    crumbs: [
                        {url: '/admin/ohio/core/users', text: 'Manager'}
                    ],
                }
            },
            'template': headingTemplate
        },
        'user-form': {
            mixins: [userService],
            template: userFormTemplate,
            mounted() {
                this.item.id = this.$route.params.id;
                this.get();
            },
        },
        roles
    },
    template: `
        <div>
            <heading></heading>
            <section class="content">
                <div class="row">
                    <div class="col-md-8">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Edit User</h3>
                            </div>
                            <user-form></user-form>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <roles></roles>
                    </div>
                </div>
            </section>
        </div>
        `
}