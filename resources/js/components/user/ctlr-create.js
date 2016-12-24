import headingTemplate from 'ohio/core/js/templates/base/heading';
import userService from './service';
import userFormTemplate from './templates/form';

export default {
    components: {
        'heading': {
            data() {
                return {
                    title: 'User Creator',
                    subtitle: '',
                    crumbs: [
                        {route: 'userIndex', text: 'Manager'}
                    ],
                }
            },
            'template': headingTemplate
        },
        'user-form': {
            mixins: [userService],
            template: userFormTemplate,
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
                                <h3 class="box-title">Create User</h3>
                            </div>
                            <user-form></user-form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        `
}