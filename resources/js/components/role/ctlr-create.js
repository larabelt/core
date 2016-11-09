import headingTemplate from 'ohio/core/js/templates/base/heading';
import roleService from './service';
import roleFormTemplate from './templates/form';

export default {
    components: {
        'heading': {
            data() {
                return {
                    title: 'Role Creator',
                    subtitle: '',
                    crumbs: [
                        {url: '/admin/ohio/core/roles', text: 'Manager'}
                    ],
                }
            },
            'template': headingTemplate
        },
        'role-form': {
            mixins: [roleService],
            template: roleFormTemplate,
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
                                <h3 class="box-title">Create Role</h3>
                            </div>
                            <role-form></role-form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        `
}