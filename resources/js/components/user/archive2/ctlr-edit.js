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
                this.users.user.id = this.$route.params.id;
                this.getUser();
            },
        },
    },
    template: `
        <div>
            <heading></heading>
            <section class="content">
                <div class="row">
                    <div class="col-md-9">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Edit User</h3>
                            </div>
                            <user-form></user-form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        `
}