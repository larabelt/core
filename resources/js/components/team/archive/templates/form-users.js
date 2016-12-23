//import teamTeamService2 from '../../team/service2';
import teamTeamService from '../team-team-service';

export default {
    mixins: [teamTeamService],
    methods: {
        search() {
            if (this.teamTeamService.params.q) {
                this.listNotTeamTeams();
            } else {
                this.teamTeamService.notTeams = [];
            }
        },
    },
    created() {
        //this.teamTeamService.params.limit = 5;
        this.teamTeamService.params.team_id = this.$route.params.id;
    },
    mounted() {
        this.listTeamTeams();
    },
    template: `
        <div class="row">
            <div class="col-md-5">
                <form role="form" class="form-inline">
                    <div class="form-group">
                        <input type="text" class="form-control" v-model.trim="teamTeamService.params.q" v-on:keyup="search($event)" placeholder="search">
                    </div>
                </form>
                <table v-if="teamTeamService.notTeams" class="table table-striped table-condensed table-hover">
                    <tbody>                
                        <tr v-for="team in teamTeamService.notTeams">
                            <td>
                                {{ team.fullname }}
                                <br/>
                                {{ team.email }}
                            </td>
                            <td class="text-right">
                                <a class="btn btn-xs btn-primary" v-on:click="attachTeamTeam({team_id: team.id})"><i class="fa fa-link"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-7">
                <table v-if="teamTeamService.teams" class="table table-striped table-condensed table-hover">
                    <tbody>                
                        <tr v-for="team in teamTeamService.teams">
                            <td>{{ team.fullname }}</td>
                            <td>{{ team.email }}</td>
                            <td class="text-right">
                                <a class="btn btn-xs btn-warning" v-on:click="detachTeamTeam(team.id)"><i class="fa fa-unlink"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    `
}