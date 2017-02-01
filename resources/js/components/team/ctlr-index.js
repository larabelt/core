import headingTemplate from 'ohio/core/js/templates/base/heading.html';
import teamService from './service';
import teamIndexTemplate from './templates/index';

export default {

    components: {
        'heading': {
            data() {
                return {
                    title: 'Team Manager',
                    subtitle: '',
                    crumbs: [],
                }
            },
            'template': headingTemplate
        },
        'team-index': {
            mixins: [teamService],
            template: teamIndexTemplate,
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
                <team-index></team-index>
            </section>
        </div>
        `
}