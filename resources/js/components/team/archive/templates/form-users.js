//import teamUserService2 from '../../user/service2';
import teamUserService from '../team-user-service';

export default {
    mixins: [teamUserService],
    methods: {
        search() {
            if (this.teamUserService.params.q) {
                this.listNotTeamUsers();
            } else {
                this.teamUserService.notUsers = [];
            }
        },
    },
    created() {
        //this.teamUserService.params.limit = 5;
        this.teamUserService.params.team_id = this.$route.params.id;
    },
    mounted() {
        this.listTeamUsers();
    },
    template: `
        <div class="row">
            <div class="col-md-5">
                <form role="form" class="form-inline">
                    <div class="form-group">
                        <input type="text" class="form-control" v-model.trim="teamUserService.params.q" v-on:keyup="search($event)" placeholder="search">
                    </div>
                </form>
                <table v-if="teamUserService.notUsers" class="table table-striped table-condensed table-hover">
                    <tbody>                
                        <tr v-for="user in teamUserService.notUsers">
                            <td>
                                {{ user.fullname }}
                                <br/>
                                {{ user.email }}
                            </td>
                            <td class="text-right">
                                <a class="btn btn-xs btn-primary" v-on:click="attachTeamUser({user_id: user.id})"><i class="fa fa-link"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-7">
                <table v-if="teamUserService.users" class="table table-striped table-condensed table-hover">
                    <tbody>                
                        <tr v-for="user in teamUserService.users">
                            <td>{{ user.fullname }}</td>
                            <td>{{ user.email }}</td>
                            <td class="text-right">
                                <a class="btn btn-xs btn-warning" v-on:click="detachTeamUser(user.id)"><i class="fa fa-unlink"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    `
}