window.$ = window.jQuery = require('jquery');

import form from 'ohio/core/js/mixins/base/forms';

export default {

    mixins: [form],

    data() {
        return {
            url: '/api/v1/users',
            user_id: ''
        }
    },
    computed: {
      fullUrl() {
          let url = this.url +
              '/' + this.user_id +
              '/roles' +
              '/';
          return url;
      }
    },
    methods: {
        paginate(query) {
            this.query = _.merge(this.query, query);
            this.query = _.merge(this.query, {not: 0});
            let url = this.fullUrl + '?' + $.param(this.query);
            this.$http.get(url).then(function (response) {
                this.attached = response.data.data;
                this.paginator = this.setPaginator(response);
            }, function (response) {
                console.log('error');
            });
        },
        paginateAll() {
            this.$http.get('/api/v1/roles').then(function (response) {
                this.items = response.data.data;
            }, function (response) {
                console.log('error');
            });
        },
        isAttached(role) {
            return _.findIndex(this.attached, ['id', role.id]) > -1;
        },
        attach(id) {
            this.errors = {};
            this.$http.post(this.fullUrl, {id: id}).then((response) => {
                this.paginate();
            }, (response) => {
                if (response.status == 422) {
                    this.errors = response.data.message;
                }
            });
            this.saving = false;
        },
        detach(id) {
            this.$http.delete(this.fullUrl + id).then(function (response) {
                if (response.status == 204) {
                    this.paginate();
                }
            });
        }
    }
};