window.$ = window.jQuery = require('jquery');

import form from 'ohio/core/js/mixins/base/forms';

export default {

    mixins: [form],

    methods: {

        attached() {

            this.union = [];

            let params = this.getParams();

            let url = '/api/v1/team-users?' + $.param(params);

            this.$http.get(url).then(function (response) {
                this.union = response.data;
            }, function (response) {
                console.log('error');
            });
        },
        link(params) {

            this.errors = {};
            this.$http.post('/api/v1/team-users', params).then((response) => {
                this.needle = '';
                //this.items = [];
                this.attached();
            }, (response) => {
                if (response.status == 422) {
                    this.errors = response.data.message;
                }
            });
            this.saving = false;
        },
        unlink(id) {
            this.$http.delete('/api/v1/team-users/' + id).then(function (response) {
                if (response.status == 204) {
                    this.attached();
                }
            });
        }
    }
};