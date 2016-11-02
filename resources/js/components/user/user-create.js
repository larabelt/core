import component_user from './templates/form-user';

export default {
    components: {
        'user-form': component_user
    },
    mounted() {
        console.log(this);
    },
    template: `
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Create User</h3>
            </div>
            
            <user-form type="create"></user-form>
            
        </div>
    `
}