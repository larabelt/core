export default {
    data() {
        return {
            roles: []
        }
    },
    methods: {
        addRole(index) {
            this.roles[index].assigned = true;

            let params = {
                role_id: this.roles[index].id,
                user_id: this.$parent.userid
            };

            this.$http.post('/api/v1/user-roles', params).then((response) => {
                //success
            }, (response) => {
                //fail
            });
        },
        buttonClick(index) {
            if (this.roles[index].assigned == true ) {
                return this.removeRole(index);
            }

            return this.addRole(index);
        },
        getRoles() {
            this.$http.get('/api/v1/roles' ).then((response) => {

                _(response.data.data).forEach( (value, index) => {

                    this.$set(this.roles, value.id, {
                        assigned: false,
                        id: value.id,
                        name: value.name,
                        slug: value.slug
                    });

                } );

                this.getUserRoles();

            }, (response) => {});
        },
        getUserRoles() {
            this.$http.get('/api/v1/user-roles?user_id=' + this.$parent.userid ).then((response) => {

                _(response.data.data).forEach( (value, index) => {
                    _(this.roles).forEach( (role, key) => {
                        if( role.id == value.role_id ) {
                            this.roles[key].assigned = true;
                        }
                    } );

                } );

            }, (response) => {});
        },
        removeRole(index) {
            this.roles[index].assigned = false;

            this.$http.delete('/api/v1/user-roles/' + this.roles[index].id).then((response) => {
                //success
            }, (response) => {
                //fail
            });
        }
    },
    mounted() {
        this.getRoles();
    },
    template: `
        <div class="box-body form-roles">
            <div class="row" v-for="(role, index) in roles">
                <button class="btn" v-bind:class="{ active: role.assigned }" v-on:click="buttonClick(index)">{{ role.name }}</button>
            </div>
        </div>
    `
}