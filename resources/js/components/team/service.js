window.$ = window.jQuery = require('jquery');

import form from 'ohio/core/js/mixins/base/forms';

export default {

    mixins: [form],

    methods: {
        index() {

            let params = this.getParams();

            let url = '/api/v1/teams?' + $.param(params);

            this.$http.get(url).then(function (response) {
                this.items = response.data;
            }, function (response) {
                console.log('error');
            });
        },
        get() {
            this.$http.get('/api/v1/teams/' + this.id).then((response) => {
                this.item = response.data;
            }, (response) => {

            });
        },
        put(params) {
            this.errors = {};
            this.$http.put('/api/v1/teams/' + this.id, params).then((response) => {
                this.item = response.data;
                this.saved = true;
            }, (response) => {
                if (response.status == 422) {
                    this.errors = response.data.message;
                }
            });
            this.saving = false;
        },
        post(params) {
            this.errors = {};
            this.$http.post('/api/v1/teams', params ).then((response) => {
                this.$router.push({ name: 'teamEdit', params: { id: response.data.id }})
            }, (response) => {
                if (response.status == 422) {
                    this.errors = response.data.message;
                }
            });
            this.saving = false;
        },
        destroy(id) {
            this.$http.delete('/api/v1/teams/' + id).then(function(response){
                if( response.status == 204 ) {
                    this.index();
                }
            });
        }
    }
};