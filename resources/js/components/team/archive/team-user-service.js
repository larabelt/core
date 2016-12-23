window.$ = window.jQuery = require('jquery');

import baseService from 'ohio/core/js/mixins/base/service';

export default {

    mixins: [baseService],

    data() {
        return {
            teamTeamService: {
                status: null,
                team: {},
                teams: [],
                notTeams: [],
                errors: {},
                params: {},
                meta: {},
            }
        }
    },

    methods: {
        baseUrl() {

            let url = '/api/v1/teams/'
                + this.teamTeamService.params.team_id
                + '/teams/';

            return url;
        },
        listNotTeamTeams() {

            this.teamTeamService.notTeams = [];

            let url = this.baseUrl()
                + '?not=1'
                + '&q=' + this.teamTeamService.params.q;

            this.$http.get(url).then(function (response) {
                this.teamTeamService.notTeams = response.data.data;
            }, function (response) {

            });

        },
        listTeamTeams() {

            this.teamTeamService.teams = [];

            let url = this.baseUrl();

            this.$http.get(url).then(function (response) {
                this.teamTeamService.teams = response.data.data;
            }, function (response) {

            });

        },
        attachTeamTeam(params) {

            this.$http.post(this.baseUrl(), params).then((response) => {
                this.listTeamTeams();
            }, (response) => {

            });

        },
        detachTeamTeam(team_id) {

            this.$http.delete(this.baseUrl() + team_id).then(function (response) {
                if (response.status == 204) {
                    this.listTeamTeams();
                }
            });

        }
    }
};