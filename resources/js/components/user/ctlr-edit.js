import headingTemplate from 'ohio/core/js/templates/base/heading';
import userService from './service';
import userFormTemplate from './templates/form';

export default {
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
    },
    template: `
        <div>
            <heading></heading>
            <section class="content">
                <div class="row">
                    <div class="col-md-9 hide">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Edit User</h3>
                            </div>
                            <user-form></user-form>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Roles</h3>
                            </div>
                            <div class="box-body">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        `
}