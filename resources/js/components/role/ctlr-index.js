import headingTemplate from 'ohio/core/js/templates/base/heading';
import roleService from './service';
import roleIndexTemplate from './templates/index';

export default {

    components: {
        'heading': {
            data() {
                return {
                    title: 'Role Manager',
                    subtitle: '',
                    crumbs: [],
                }
            },
            'template': headingTemplate
        },
        'role-index': {
            mixins: [roleService],
            template: roleIndexTemplate,
            mounted() {
                this.paginateRoles();
            },
            watch: {
                '$route' (to, from) {
                    this.paginateRoles();
                }
            },
        },
    },

    template: `
        <div>
            <heading></heading>
            <section class="content">
                <role-index></role-index>
            </section>
        </div>
        `
}