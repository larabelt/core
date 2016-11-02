import component_role from './templates/form-role';

export default {
    components: {
        'form-role': component_role
    },
    mounted() {
        console.log(this);
    },
    template: `
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Create User</h3>
            </div>
            
            <form-role type="create"></form-role>
            
        </div>
    `
}