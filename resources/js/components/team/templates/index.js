export default `
    <div class="box box-primary">
        <div class="box-body">
            <div class="btn-group">
                <router-link to="/teams/create" v-bind:class="'btn btn-primary'">add team</router-link>
            </div>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>
                            ID
                            <column-sorter :route="'teamIndex'" :paginator="teams.paginator" :order-by="'teams.id'"></column-sorter>
                        </th>
                        <th>
                            Name
                            <column-sorter :route="'teamIndex'" :paginator="teams.paginator" :order-by="'teams.name'"></column-sorter>
                        </th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>                
                    <tr v-for="team in teams.teams">
                        <td>{{ team.id }}</td>
                        <td>{{ team.name }}</td>
                        <td class="text-right">
                            <router-link :to="{ name: 'teamEdit', params: { id: team.id } }" v-bind:class="'btn btn-xs btn-warning'">
                                <i class="fa fa-edit"></i>
                            </router-link>
                            <a class="btn btn-xs btn-danger" v-on:click="destroyTeam(team.id)"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </tfoot>
            </table>
            <pagination :route="'teamIndex'" :paginator="teams.paginator"></pagination>
        </div>
    </div>
`;