window.$ = window.jQuery = require('jquery');

import form from 'ohio/core/js/mixins/base/forms';

export default {

    mixins: [form],

    data() {
        return {
            teams: {
                team: {},
                teams: [],
                url: '/api/v1/teams/',
                errors: {},
                paginator: {},
                params: {},
                saved: false,
                saving: false,
            }
        }
    },

    methods: {
        submitTeam(event) {
            event.preventDefault();
            this.teams.saving = true;
            this.teams.saved = false;
            if (this.teams.team.id) {
                return this.updateTeam(this.teams.team);
            }
            return this.storeTeam(this.teams.team);
        },
        paginateTeams() {
            let url = this.teams.url + '?' + $.param(this.getUrlParams());
            this.$http.get(url).then(function (response) {
                this.teams.teams = response.data.data;
                this.teams.paginator = this.getPaginatorData(response);
            }, function (response) {
                console.log('error');
            });
        },
        getTeam() {
            this.$http.get(this.teams.url + this.teams.team.id).then((response) => {
                this.teams.team = response.data;
            }, (response) => {

            });
        },
        updateTeam(params) {
            this.teams.errors = {};
            this.$http.put(this.teams.url + this.teams.team.id, params).then((response) => {
                this.teams.team = response.data;
                this.teams.saved = true;
            }, (response) => {
                if (response.status == 422) {
                    this.teams.errors = response.data.message;
                }
            });
            this.teams.saving = false;
        },
        storeTeam(params) {
            this.teams.errors = {};
            this.$http.post(this.teams.url, params).then((response) => {
                this.$router.push({ name: 'teamEdit', params: { id: response.data.id }})
            }, (response) => {
                if (response.status == 422) {
                    this.teams.errors = response.data.message;
                }
            });
            this.teams.saving = false;
        },
        destroyTeam(id) {
            this.$http.delete(this.teams.url + id).then(function(response){
                if( response.status == 204 ) {
                    this.paginateTeams();
                }
            });
        }
    }
};