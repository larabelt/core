export default {
    components: {
        'user-form': require('./templates/form-user')
    },
    data() {
        return {
            userid: this.$route.params.id
        }
    },
    mounted() {
        console.log(this);
    },
    template: `
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit User</h3>
                    </div>
                    <user-form type="edit"></user-form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Roles</h3>
                    </div>
                    <div class="box-body">
                        roles form
                    </div>
                </div>
            </div>
        </div>
    `
}