export default `
    <form role="form">
        <div class="box-body">
            <div class="checkbox">
                <label>
                    <input type="checkbox" 
                        v-model="item.is_active"
                        v-bind:true-value="1"
                        v-bind:false-value="0"
                        > Is Active
                </label>
            </div>
            <div class="form-group" v-bind:class="{ 'has-error': errors.email }">
                <label for="email">Email</label>
                <input type="email" class="form-control" v-model.trim="item.email"  placeholder="email">
                <span class="help-block" v-show="errors.email">{{ errors.email }}</span>
            </div>
            <div class="form-group" v-bind:class="{ 'has-error': errors.password }">
                <label for="password">Password</label>
                <input type="password" class="form-control" v-model.trim="item.password" placeholder="password">
                <span class="help-block" v-show="errors.password">{{ errors.password }}</span>
            </div>
            <div class="form-group">
                <label for="password">Password Confirmation</label>
                <input type="password" class="form-control" v-model.trim="item.password_confirmation" placeholder="retype password">
            </div>
            <div class="form-group" v-bind:class="{ 'has-error': errors.first_name }">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" v-model.trim="item.first_name" placeholder="first name">
                <span class="help-block" v-show="errors.first_name">{{ errors.first_name }}</span>
            </div>
            <div class="form-group">
                <label for="mi">MI</label>
                <input type="text" class="form-control" v-model.trim="item.mi" placeholder="mi">                 
            </div>
            <div class="form-group" v-bind:class="{ 'has-error': errors.last_name }">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control" v-model.trim="item.last_name" placeholder="last name">
                <span class="help-block" v-show="errors.last_name">{{ errors.last_name }}</span>
            </div>
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-primary" v-on:click="submit($event)">Save</button>
            <span v-show="saving">saving <i class="fa fa-spinner fa-spin" /></span>
            <span v-show="saved">saved <i class="fa fa-floppy-o" /></span>
        </div>
    </form>
`