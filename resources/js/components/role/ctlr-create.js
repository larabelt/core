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
                        {route: 'roleIndex', text: 'Roles'}
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
                <div class="box">
                    <div class="box-body">
                        <role-form></role-form>
                    </div>
                </div>
            </section>
        </div>
        `
}