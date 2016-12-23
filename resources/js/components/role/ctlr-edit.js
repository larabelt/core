import headingTemplate from 'ohio/core/js/templates/base/heading';
import roleService from './service';
import roleFormTemplate from './templates/form';

export default {
    components: {
        'heading': {
            data() {
                return {
                    title: 'Role Editor',
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
                    <div class="col-md-9">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Edit Role</h3>
                            </div>
                            <role-form></role-form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        `
}