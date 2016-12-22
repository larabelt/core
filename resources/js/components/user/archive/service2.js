window.$ = window.jQuery = require('jquery');

import baseService from 'ohio/core/js/mixins/base/service';

export default {

    mixins: [baseService],

    data() {
        return {
            userService: {
                status: null,
                user: {},
                users: [],
                errors: {},
                params: {},
                meta: {},
            }
        }
    },

    methods: {
        listUsers() {

            if (this.$route != undefined) {
                this.pushRouteQueryToParams('userService');
            }

            let url = '/api/v1/users?' + $.param(this.userService.params);

            this.$http.get(url).then(function (response) {
                this.userService.users = response.data.data;
            }, function (response) {

            });
        },
        showUser() {
            this.$http.get('/api/v1/users/' + this.id).then((response) => {
                this.item = response.data;
            }, (response) => {

            });
        },
        updateUser(params) {
            this.errors = {};
            this.$http.put('/api/v1/users/' + this.id, params).then((response) => {
                this.item = response.data;
                this.saved = true;
            }, (response) => {
                if (response.status == 422) {
                    this.errors = response.data.message;
                }
            });
            this.saving = false;
        },
        storeUser(params) {
            this.errors = {};
            this.$http.post('/api/v1/users', params ).then((response) => {
                this.$router.push({ name: 'userEdit', params: { id: response.data.id }})
            }, (response) => {
                if (response.status == 422) {
                    this.errors = response.data.message;
                }
            });
            this.saving = false;
        },
        deleteUser(id) {
            this.$http.delete('/api/v1/users/' + id).then(function(response){
                if( response.status == 204 ) {
                    this.index();
                }
            });
        }
    }
};