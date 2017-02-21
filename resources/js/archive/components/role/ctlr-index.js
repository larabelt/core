import headingTemplate from 'belt/core/js/templates/base/heading.html';
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
                this.query = this.getUrlQuery();
                this.paginate();
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