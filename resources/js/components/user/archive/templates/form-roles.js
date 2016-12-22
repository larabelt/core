export default {
    data() {
        return {
            roles: []
        }
    },
    methods: {
        getRoles() {

            this.roles = [];

            this.$http.get('/api/v1/roles' ).then((response) => {
                _(response.data.data).forEach( (role, index) => {
                    this.roles.push({
                        userRoleID: false,
                        id: role.id,
                        name: role.name,
                        slug: role.slug
                    })
                } );

                this.getUserRoles();

            }, (response) => {});
        },
        getUserRoles() {

            this.$http.get('/api/v1/user-roles?user_id=' + this.$parent.id ).then((response) => {

                _(response.data.data).forEach( (userRole, index) => {
                    _(this.roles).forEach( (role, key) => {
                        if( role.id == userRole.role_id ) {
                            this.roles[key].userRoleID = userRole.id;
                        }
                    } );

                } );

            }, (response) => {});
        },
        buttonClick(index) {
            if (this.roles[index].userRoleID != false ) {
                return this.removeRole(index);
            }

            return this.addRole(index);
        },
        addRole(index) {

            let params = {
                role_id: this.roles[index].id,
                user_id: this.$parent.id
            };

            this.$http.post('/api/v1/user-roles', params).then((response) => {
                this.roles[index].userRoleID = response.data.id;
            }, (response) => {
                //fail
            });
        },
        removeRole(index) {
            this.$http.delete('/api/v1/user-roles/' + this.roles[index].userRoleID).then((response) => {
                if( response.status == 204 ) {
                    this.roles[index].userRoleID = false;
                }
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
                <button class="btn" v-bind:class="{ active: role.userRoleID }" v-on:click="buttonClick(index)">{{ role.name }}</button>
            </div>
        </div>
    `
}