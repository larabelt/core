export default `
    <div class="box box-primary">
        <div class="box-body">
            <div class="btn-group">
                <router-link to="/users/create" v-bind:class="'btn btn-primary'">add user</router-link>
            </div>
            
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>
                            ID
                            <column-sorter :route="'userIndex'" :column="'users.id'"></column-sorter>
                        </th>
                        <th>
                            Email
                            <column-sorter :route="'userIndex'" :column="'users.email'"></column-sorter>
                        </th>
                        <th>
                            First Name
                            <column-sorter :route="'userIndex'" :column="'users.first_name'"></column-sorter>
                        </th>
                        <th>
                            Last Name
                            <column-sorter :route="'userIndex'" :column="'users.last_name'"></column-sorter>
                        </th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>                
                    <tr v-for="user in items">
                        <td>{{ user.id }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.first_name }}</td>
                        <td>{{ user.last_name }}</td>
                        <td class="text-right">
                            <router-link :to="{ name: 'userEdit', params: { id: user.id } }" v-bind:class="'btn btn-xs btn-warning'">
                                <i class="fa fa-edit"></i>
                            </router-link>
                            <a class="btn btn-xs btn-danger" v-on:click="destroy(user.id)"><i class="fa fa-trash"></i></a>
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
            <pagination :route="'userIndex'"></pagination>
        </div>
    </div>
`;