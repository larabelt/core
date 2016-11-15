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
                            <column-sorter :routename="'teamIndex'" :order-by="'teams.id'"></column-sorter>
                        </th>
                        <th>
                            Email
                            <column-sorter :routename="'teamIndex'" :order-by="'teams.email'"></column-sorter>
                        </th>
                        <th>
                            First Name
                            <column-sorter :routename="'teamIndex'" :order-by="'teams.first_name'"></column-sorter>
                        </th>
                        <th>
                            Last Name
                            <column-sorter :routename="'teamIndex'" :order-by="'teams.last_name'"></column-sorter>
                        </th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>                
                    <tr v-for="item in items.data">
                        <td>{{ item.id }}</td>
                        <td>{{ item.email }}</td>
                        <td>{{ item.first_name }}</td>
                        <td>{{ item.last_name }}</td>
                        <td class="text-right">
                            <router-link :to="{ name: 'teamEdit', params: { id: item.id } }" v-bind:class="'btn btn-xs btn-warning'">
                                <i class="fa fa-edit"></i>
                            </router-link>
                            <a class="btn btn-xs btn-danger" v-on:click="destroy(item.id)"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </tfoot>
            </table>
            <pagination :routename="'teamIndex'"></pagination>
        </div>
    </div>
`;