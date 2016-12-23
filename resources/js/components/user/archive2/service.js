window.$ = window.jQuery = require('jquery');

import form from 'ohio/core/js/mixins/base/forms';

export default {

    mixins: [form],

    data() {
        return {
            users: {
                user: {},
                users: [],
                url: '/api/v1/users/',
                errors: {},
                paginator: {},
                params: {},
                saved: false,
                saving: false,
            }
        }
    },

    methods: {
        submitUser(event) {
            event.preventDefault();
            this.users.saving = true;
            this.users.saved = false;
            if (this.users.user.id) {
                return this.updateUser(this.users.user);
            }
            return this.storeUser(this.users.user);
        },
        paginateUsers(query) {

            query = _.merge(this.users.params, query);

            let url = this.users.url + '?' + $.param(query);

            this.$http.get(url).then(function (response) {
                this.users.users = response.data.data;
                this.users.paginator = this.setPaginator(response);
            }, function (response) {
                console.log('error');
            });
        },
        getUser() {
            this.$http.get(this.users.url + this.users.user.id).then((response) => {
                this.users.user = response.data;
            }, (response) => {

            });
        },
        updateUser(params) {
            this.users.errors = {};
            this.$http.put(this.users.url + this.users.user.id, params).then((response) => {
                this.users.user = response.data;
                this.users.saved = true;
            }, (response) => {
                if (response.status == 422) {
                    this.users.errors = response.data.message;
                }
            });
            this.users.saving = false;
        },
        storeUser(params) {
            this.users.errors = {};
            this.$http.post(this.users.url, params).then((response) => {
                this.$router.push({ name: 'userEdit', params: { id: response.data.id }})
            }, (response) => {
                if (response.status == 422) {
                    this.users.errors = response.data.message;
                }
            });
            this.users.saving = false;
        },
        destroyUser(id) {
            this.$http.delete(this.users.url + id).then(function(response){
                if( response.status == 204 ) {
                    this.paginateUsers();
                }
            });
        }
    }
};