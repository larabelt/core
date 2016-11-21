window.$ = window.jQuery = require('jquery');

import baseService from 'ohio/core/js/mixins/base/service';

export default {

    mixins: [baseService],

    data() {
        return {
            teamUserService: {
                status: null,
                user: {},
                users: [],
                notUsers: [],
                errors: {},
                params: {},
                meta: {},
            }
        }
    },

    methods: {
        baseUrl() {

            let url = '/api/v1/teams/'
                + this.teamUserService.params.team_id
                + '/users/';

            return url;
        },
        listNotTeamUsers() {

            this.teamUserService.notUsers = [];

            let url = this.baseUrl()
                + '?not=1'
                + '&q=' + this.teamUserService.params.q;

            this.$http.get(url).then(function (response) {
                this.teamUserService.notUsers = response.data.data;
            }, function (response) {

            });

        },
        listTeamUsers() {

            this.teamUserService.users = [];

            let url = this.baseUrl();

            this.$http.get(url).then(function (response) {
                this.teamUserService.users = response.data.data;
            }, function (response) {

            });

        },
        attachTeamUser(params) {

            this.$http.post(this.baseUrl(), params).then((response) => {
                this.listTeamUsers();
            }, (response) => {

            });

        },
        detachTeamUser(user_id) {

            this.$http.delete(this.baseUrl() + user_id).then(function (response) {
                if (response.status == 204) {
                    this.listTeamUsers();
                }
            });

        }
    }
};