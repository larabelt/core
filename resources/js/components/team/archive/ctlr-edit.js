import headingTemplate from 'ohio/core/js/templates/base/heading';
import teamService from './team-service';
import teamFormTemplate from './templates/form';
import teamUserForm from './templates/form-users';

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
                this.id = this.$route.params.id;
                this.get();
            },
        },
        'team-user-form': teamUserForm,
    },
    data() {
        return {
            id: this.$route.params.id
        }
    },
    template: `
        <div>
            <heading></heading>
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Edit Team</h3>
                            </div>
                            <team-form></team-form>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Team Users</h3>
                            </div>
                            <div class="box-body">
                                <team-user-form></team-user-form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        `
}