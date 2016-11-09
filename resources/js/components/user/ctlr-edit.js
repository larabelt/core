import headingTemplate from 'ohio/core/js/templates/base/heading';
import userService from './service';
import userFormTemplate from './templates/form';
import rolesFormComponent from './templates/form-roles';

export default {
    components: {
        'heading': {
            data() {
                return {
                    title: 'User Editor',
                    subtitle: '',
                    crumbs: [
                        {url: '/admin/ohio/core/users', text: 'Manager'}
                    ],
                }
            },
            'template': headingTemplate
        },
        'user-form': {
            mixins: [userService],
            template: userFormTemplate,
            mounted() {
                this.id = this.$route.params.id;
                this.get();
            },
        },
        'roles-form': rolesFormComponent,
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
                    <div class="col-md-6">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Edit User</h3>
                            </div>
                            <user-form></user-form>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Roles</h3>
                            </div>
                            <div class="box-body">
                                <roles-form></roles-form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        `
}