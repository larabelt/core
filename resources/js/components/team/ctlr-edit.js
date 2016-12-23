import headingTemplate from 'ohio/core/js/templates/base/heading';
import teamService from './service';
import teamFormTemplate from './templates/form';

export default {
    components: {
        'heading': {
            data() {
                return {
                    title: 'Team Editor',
                    subtitle: '',
                    crumbs: [
                        {url: '/admin/ohio/core/teams', text: 'Manager'}
                    ],
                }
            },
            'template': headingTemplate
        },
        'team-form': {
            mixins: [teamService],
            template: teamFormTemplate,
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
                                <h3 class="box-title">Edit Team</h3>
                            </div>
                            <team-form></team-form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        `
}