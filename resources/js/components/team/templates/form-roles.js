export default {
    data() {
        return {
            users: []
        }
    },
    methods: {
        getUsers() {

            this.users = [];

            this.$http.get('/api/v1/users' ).then((response) => {
                _(response.data.data).forEach( (user, index) => {
                    this.users.push({
                        teamUserID: false,
                        id: user.id,
                        name: user.name,
                        slug: user.slug
                    })
                } );

                this.getTeamUsers();

            }, (response) => {});
        },
        getTeamUsers() {

            this.$http.get('/api/v1/team-users?team_id=' + this.$parent.id ).then((response) => {

                _(response.data.data).forEach( (teamUser, index) => {
                    _(this.users).forEach( (user, key) => {
                        if( user.id == teamUser.user_id ) {
                            this.users[key].teamUserID = teamUser.id;
                        }
                    } );

                } );

            }, (response) => {});
        },
        buttonClick(index) {
            if (this.users[index].teamUserID != false ) {
                return this.removeUser(index);
            }

            return this.addUser(index);
        },
        addUser(index) {

            let params = {
                user_id: this.users[index].id,
                team_id: this.$parent.id
            };

            this.$http.post('/api/v1/team-users', params).then((response) => {
                this.users[index].teamUserID = response.data.id;
            }, (response) => {
                //fail
            });
        },
        removeUser(index) {
            this.$http.delete('/api/v1/team-users/' + this.users[index].teamUserID).then((response) => {
                if( response.status == 204 ) {
                    this.users[index].teamUserID = false;
                }
            }, (response) => {
                //fail
            });
        }
    },
    mounted() {
        this.getUsers();
    },
    template: `
        <div class="box-body form-users">
            <div class="row" v-for="(user, index) in users">
                <button class="btn" v-bind:class="{ active: user.teamUserID }" v-on:click="buttonClick(index)">{{ user.name }}</button>
            </div>
        </div>
    `
}