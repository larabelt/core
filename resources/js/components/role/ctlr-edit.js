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
                        {route: 'roleIndex', text: 'Roles'}
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
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs pull-right">
                        <li class="active"><a href="#tab_1-1" data-toggle="tab" aria-expanded="false">Main</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1-1">
                            <role-form></role-form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        `
}