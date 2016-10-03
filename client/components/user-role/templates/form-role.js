let lodash = require('lodash');

export default {
    data() {
        return {
            fields: {
                name: '',
                slug: ''
            },
            invalid: {
                name: false,
                slug: false
            }
        }
    },
    methods: {
        formSubmit(event) {
            event.preventDefault();

            if( this.formIsValid() ) {
                let params = {
                    name: this.fields.name,
                    slug: this.fields.slug
                };

                if( this.type == 'edit' ) {
                    params.id = this.fields.id;
                    this.putItem(params);
                    return;
                }

                this.postItem(params);
                return;
            }
        },
        formIsValid() {
            let isValid = true;

            lodash(this.invalid).forEach( (value, index) => {
                this.invalid[index] = false;
            });

            if( this.fields.name == '' ) {
                this.invalid.name = true;
                isValid = false;
            }

            if( this.fields.slug == '' ) {
                this.invalid.slug = true;
                isValid = false;
            }

            return isValid;
        },
        getError(type) {
            let message = "This field is required";
            switch (type) {
                case 'name':
                    message = "Please enter a name.";
                    break;
                case 'slug':
                    message = "Please enter a slug.";
                    break;
            }

            return message;
        },
        getItem() {
            this.$http.get('/api/v1/roles/' + this.$parent.roleid ).then((response) => {
                this.fields.id = response.data.id;
                this.fields.name = response.data.name;
                this.fields.slug = response.data.slug;
            }, (response) => {});
        },
        postItem(params) {
            this.$http.post('/api/v1/roles', params ).then((response) => {
                console.log(response);
                this.$router.push({ name: 'roleEdit', params: { id: response.data.id }})
            }, (response) => {});
        },
        putItem(params) {
            this.$http.put('/api/v1/roles/' + params.id, params ).then((response) => {
                console.log(response);
                this.$router.push({ name: 'roleEdit', params: { id: response.data.id }})
            }, (response) => {});
        }
    },
    mounted() {
        if( this.type == 'edit' ) {
            this.getItem();
        }
    },
    props: ['type'],
    template: `
        <form role="form">
            <div class="box-body">
                
                <div class="form-group" v-bind:class="{ 'has-error': invalid.name }">
                    <label for="name">Name</label>
                    <input type="name" class="form-control" v-model.trim="fields.name"  placeholder="name">
                        <span class="help-block" v-show="invalid.name">{{ getError('name') }}</span>
                </div>
                <div class="form-group" v-bind:class="{ 'has-error': invalid.slug }">
                    <label for="slug">Slug</label>
                    <input type="text" class="form-control" v-model.trim="fields.slug" placeholder="slug">
                        <span class="help-block" v-show="invalid.slug">{{ getError('slug') }}</span>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary" v-on:click="formSubmit($event)">Save</button>
            </div>
        </form>
    `
};