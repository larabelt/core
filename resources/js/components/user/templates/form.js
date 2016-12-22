export default `
    <form user="form">
        <div class="box-body">
            <div class="checkbox">
                <label>
                    <input type="checkbox" 
                        v-model="users.user.is_active"
                        v-bind:true-value="1"
                        v-bind:false-value="0"
                        > Is Active
                </label>
            </div>
            <div class="form-group" v-bind:class="{ 'has-error': users.errors.email }">
                <label for="email">Email</label>
                <input type="email" class="form-control" v-model.trim="users.user.email"  placeholder="email">
                <span class="help-block" v-show="users.errors.email">{{ users.errors.email }}</span>
            </div>
            <div class="form-group" v-bind:class="{ 'has-error': users.errors.password }">
                <label for="password">Password</label>
                <input type="password" class="form-control" v-model.trim="users.user.password" placeholder="password">
                <span class="help-block" v-show="users.errors.password">{{ users.errors.password }}</span>
            </div>
            <div class="form-group">
                <label for="password">Password Confirmation</label>
                <input type="password" class="form-control" v-model.trim="users.user.password_confirmation" placeholder="retype password">
            </div>
            <div class="form-group" v-bind:class="{ 'has-error': users.errors.first_name }">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" v-model.trim="users.user.first_name" placeholder="first name">
                <span class="help-block" v-show="users.errors.first_name">{{ users.errors.first_name }}</span>
            </div>
            <div class="form-group">
                <label for="mi">MI</label>
                <input type="text" class="form-control" v-model.trim="users.user.mi" placeholder="mi">                 
            </div>
            <div class="form-group" v-bind:class="{ 'has-error': users.errors.last_name }">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control" v-model.trim="users.user.last_name" placeholder="last name">
                <span class="help-block" v-show="users.errors.last_name">{{ users.errors.last_name }}</span>
            </div>
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-primary" v-on:click="submitUser($event)">Save</button>
            <span v-show="users.saving">saving <i class="fa fa-spinner fa-spin" /></span>
            <span v-show="users.saved">saved <i class="fa fa-floppy-o" /></span>
        </div>
    </form>
`