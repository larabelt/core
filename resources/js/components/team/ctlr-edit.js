import headingTemplate from 'ohio/core/js/templates/base/heading.html';
import teamService from './service';
import teamFormTemplate from './templates/form';
import users from './user/ctlr-edit';

export default {
    data() {
        return {
            morphable_type: 'teams',
            morphable_id: this.$route.params.id,
        }
    },
    components: {
        'heading': {
            data() {
                return {
                    title: 'Team Editor',
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
            mounted() {
                this.item.id = this.$route.params.id;
                this.get();
            },
        },
        users
    },
    template: `
        <div>
            <heading></heading>
            <section class="content">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs pull-right">
                        <li class="active"><a href="#tab_1-1" data-toggle="tab" aria-expanded="false">Main</a></li>
                        <li class=""><a href="#tab_2-2" data-toggle="tab" aria-expanded="false">Users</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1-1">
                            <team-form></team-form>
                        </div>
                        <div class="tab-pane" id="tab_2-2">
                            <users></users>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        `
}