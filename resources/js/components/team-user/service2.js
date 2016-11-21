window.$ = window.jQuery = require('jquery');

import baseService from 'ohio/core/js/mixins/base/service';

export default {

    mixins: [baseService],

    data() {
        return {
            teamUserService: {
                status: null,
                teamUser: {},
                teamUsers: [],
                errors: {},
                params: {},
                meta: {},
            }
        }
    },

    methods: {
        listTeamUsers() {

            this.teamUserService.teamUsers = [];

            if (this.$route != undefined) {
                this.pushRouteQueryToParams('teamUserService');
            }

            let url = '/api/v1/team-users?' + $.param(this.teamUserService.params);

            this.$http.get(url).then(function (response) {
                this.teamUserService.teamUsers = response.data.data;
            }, function (response) {

            });
        },
        storeTeamUser(params) {
            this.teamUserService.errors = {};
            this.$http.post('/api/v1/team-users', params).then((response) => {
                this.listTeamUsers();
            }, (response) => {
                if (response.status == 422) {
                    this.errors = response.data.message;
                }
            });
            this.saving = false;
        },
        deleteTeamUser(id) {
            this.$http.delete('/api/v1/team-users/' + id).then(function (response) {
                if (response.status == 204) {
                    this.listTeamUsers();
                }
            });
        }
    }
};