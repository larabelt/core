import component_role from './templates/form-role';

export default {
    components: {
        'form-role': component_role
    },
    data() {
        return {
            roleid: this.$route.params.id
        }
    },
    mounted() {
        console.log(this);
    },
    template: `
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit Role</h3>
                    </div>
                    <form-role type="edit"></form-role>
                </div>
            </div>
        </div>
    `
}