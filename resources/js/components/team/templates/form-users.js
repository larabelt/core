import userService from '../../user/service';
import teamUserService from '../../team-user/service';

export default {
    mixins: [userService, teamUserService],
    data() {
        return {
            team_id: this.$route.params.id
        }
    },
    methods: {
        search() {
            if (this.needle) {
                this.index();
            } else {
                this.items = []
            }
        },
        getParams() {
            let params = this.getUrlParams();
            params.q = this.needle;
            params.limit = 5;
            params.team_id = this.team_id;
            return params;
        },
    },
    mounted() {
        this.attached();
    },
    template: `
        <div class="row">
            <div class="col-md-5">
                <form role="form" class="form-inline">
                    <div class="form-group">
                        <input type="text" class="form-control" v-model.trim="needle" v-on:keyup="search($event)" placeholder="search">
                    </div>
                </form>
                <table v-if="items.data" class="table table-striped table-condensed table-hover">
                    <tbody>                
                        <tr v-for="item in items.data">
                            <td>
                                {{ item.fullname }}
                                <br/>
                                {{ item.email }}
                            </td>
                            <td class="text-right">
                                <a class="btn btn-xs btn-primary" v-on:click="link({user_id: item.id, team_id: team_id})"><i class="fa fa-link"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-7">
                <table v-if="union.data" class="table table-striped table-condensed table-hover">
                    <tbody>                
                        <tr v-for="item in union.data">
                            <td>{{ item.user.fullname }}</td>
                            <td>{{ item.user.email }}</td>
                            <td class="text-right">
                                <a class="btn btn-xs btn-primary" v-on:click="unlink(item.id)"><i class="fa fa-unlink"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    `
}