export default {
    components: {
        'user-form': require('./templates/form-user')
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