let lodash = require('lodash');

export default {
    data() {
        return {
            fields: {
                email: '',
                first_name: '',
                last_name: '',
                password: '',
                mi: '',
                is_active: 1
            },
            invalid: {
                email: false,
                first_name: false,
                last_name: false,
                password: false,
            }
        }
    },
    methods: {
        formSubmit(event) {
            event.preventDefault();

            if( this.formIsValid() ) {
                let params = {
                    email: this.fields.email,
                    first_name: this.fields.first_name,
                    last_name: this.fields.last_name,
                    password: this.fields.password,
                    mi: this.fields.mi,
                    is_active: this.fields.is_active
                };

                if( this.type == 'edit' ) {
                    params.id = this.fields.id;
                    this.putUser(params);
                    return;
                }

                this.postUser(params);
                return;
            }
        },
        formIsValid() {
            let isValid = true;

            lodash(this.invalid).forEach( (value, index) => {
                this.invalid[index] = false;
            });

            if( this.fields.email == '' ) {
                this.invalid.email = true;
                isValid = false;
            }

            if( this.fields.first_name == '' ) {
                this.invalid.first_name = true;
                isValid = false;
            }

            if( this.fields.last_name == '' ) {
                this.invalid.last_name = true;
                isValid = false;
            }

            if( this.fields.password == '' ) {
                this.invalid.password = true;
                isValid = false;
            }

            return isValid;
        },
        getError(type) {
            let message = "This field is required";
            switch (type) {
                case 'email':
                    message = "Please enter an email.";
                    break;
                case 'password':
                    message = "Please enter a password.";
                    break;
                case 'first_name':
                    message = "Please enter a first name.";
                    break;
                case 'last_name':
                    message = "Please enter a last name.";
                    break;
            }

            return message;
        },
        getUser() {
            this.$http.get('/api/v1/users/' + this.$parent.userid ).then((response) => {
                this.fields.id = response.data.id;
                this.fields.email = response.data.email;
                this.fields.first_name = response.data.first_name;
                this.fields.last_name = response.data.last_name;
                this.fields.password = response.data.password;
                this.fields.mi = response.data.mi;
                this.fields.is_active = response.data.is_active;
            }, (response) => {});
        },
        postUser(params) {
            this.$http.post('/api/v1/users', params ).then((response) => {
                console.log(response);
                this.$router.push({ name: 'userEdit', params: { id: response.data.id }})
            }, (response) => {});
        },
        putUser(params) {
            this.$http.put('/api/v1/users/' + params.id, params ).then((response) => {
                console.log(response);
                this.$router.push({ name: 'userEdit', params: { id: response.data.id }})
            }, (response) => {});
        }
    },
    mounted() {
        if( this.type == 'edit' ) {
            this.getUser();
        }
    },
    props: ['type'],
    template: `
        <form role="form">
            <div class="box-body">
            <div class="checkbox">
                <label>
                    <input type="checkbox" 
                        v-model="fields.is_active"
                        v-bind:true-value="1"
                        v-bind:false-value="0"
                        > Is Active
                </label>
            </div>
            <div class="form-group" v-bind:class="{ 'has-error': invalid.email }">
                <label for="email">Email</label>
                <input type="email" class="form-control" v-model.trim="fields.email"  placeholder="email">
                    <span class="help-block" v-show="invalid.email">{{ getError('email') }}</span>
            </div>
            <div class="form-group" v-bind:class="{ 'has-error': invalid.password }">
                <label for="password">Password</label>
                <input type="password" class="form-control" v-model.trim="fields.password" placeholder="password">
                    <span class="help-block" v-show="invalid.password">{{ getError('password') }}</span>
            </div>
            <div class="form-group" v-bind:class="{ 'has-error': invalid.first_name }">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" v-model.trim="fields.first_name" placeholder="first name">
                    <span class="help-block" v-show="invalid.first_name">{{ getError('first_name') }}</span>
            </div>
            <div class="form-group">
                <label for="mi">MI</label>
                <input type="text" class="form-control" v-model.trim="fields.mi" placeholder="mi">
                    <!--<span class="help-block" ng-show="hasError('mi')">{{ getError('mi') }}</span>-->
            </div>
            <div class="form-group" v-bind:class="{ 'has-error': invalid.last_name }">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control" v-model.trim="fields.last_name" placeholder="last name">
                    <span class="help-block" v-show="invalid.last_name">{{ getError('last_name') }}</span>
            </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary" v-on:click="formSubmit($event)">Save</button>
            </div>
        </form>
    `
};