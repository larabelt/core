import headingTemplate from 'ohio/core/js/templates/base/heading.html';
import teamService from './service';
import teamFormTemplate from './templates/form';

export default {
    components: {
        'heading': {
            data() {
                return {
                    title: 'Team Creator',
                    subtitle: '',
                    crumbs: [
                        {route: 'teamIndex', text: 'Teams'}
                    ],
                }
            },
            'template': headingTemplate
        },
        'team-form': {
            mixins: [teamService],
            template: teamFormTemplate,
        },
    },
    template: `
        <div>
            <heading></heading>
            <section class="content">
                <div class="box">
                    <div class="box-body">
                        <team-form></team-form>
                    </div>
                </div>
            </section>
        </div>       
        `
}