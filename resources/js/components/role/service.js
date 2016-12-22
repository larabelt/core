window.$ = window.jQuery = require('jquery');

import form from 'ohio/core/js/mixins/base/forms';

export default {

    mixins: [form],

    data() {
        return {
            roles: {
                url: '/api/v1/roles/',
                saving: false,
                saved: false,
                errors: {},
                params: {},
                role: {},
                roles: [],
            }
        }
    },

    methods: {
        submitRole(event) {
            event.preventDefault();
            this.roles.saving = true;
            this.roles.saved = false;
            if (this.roles.role.id) {
                return this.updateRole(this.roles.role);
            }
            return this.storeRole(this.roles.role);
        },
        paginateRoles() {
            let url = this.roles.url + '?' + $.param(this.getUrlParams());
            this.$http.get(url).then(function (response) {
                this.roles.roles = response.data.data;
            }, function (response) {
                console.log('error');
            });
        },
        getRole() {
            this.$http.get(this.roles.url + this.roles.role.id).then((response) => {
                this.roles.role = response.data;
            }, (response) => {

            });
        },
        updateRole(params) {
            this.roles.errors = {};
            this.$http.put(this.roles.url + this.roles.role.id, params).then((response) => {
                this.roles.role = response.data;
                this.roles.saved = true;
            }, (response) => {
                if (response.status == 422) {
                    this.roles.errors = response.data.message;
                }
            });
            this.roles.saving = false;
        },
        storeRole(params) {
            this.roles.errors = {};
            this.$http.post(this.roles.url, params ).then((response) => {
                this.$router.push({ name: 'roleEdit', params: { id: response.data.id }})
            }, (response) => {
                if (response.status == 422) {
                    this.roles.errors = response.data.message;
                }
            });
            this.roles.saving = false;
        },
        destroyRole(id) {
            this.$http.delete(this.roles.url + id).then(function(response){
                if( response.status == 204 ) {
                    this.paginateRoles();
                }
            });
        }
    }
};