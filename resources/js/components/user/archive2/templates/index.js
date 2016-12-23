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
                            <column-sorter :zroute="'userIndex'" :paginator="users.paginator" :order-by="'users.id'" :paginateBy="paginateUsers"></column-sorter>
                        </th>
                        <th>
                            Email
                            <column-sorter :zroute="'userIndex'" :paginator="users.paginator" :order-by="'users.email'" :paginateBy="paginateUsers"></column-sorter>
                        </th>
                        <th>
                            First Name
                            <column-sorter :zroute="'userIndex'" :paginator="users.paginator" :order-by="'users.first_name'" :paginateBy="paginateUsers"></column-sorter>
                        </th>
                        <th>
                            Last Name
                            <column-sorter :zroute="'userIndex'" :paginator="users.paginator" :order-by="'users.last_name'" :paginateBy="paginateUsers"></column-sorter>
                        </th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>                
                    <tr v-for="user in users.users">
                        <td>{{ user.id }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.first_name }}</td>
                        <td>{{ user.last_name }}</td>
                        <td class="text-right">
                            <router-link :to="{ name: 'userEdit', params: { id: user.id } }" v-bind:class="'btn btn-xs btn-warning'">
                                <i class="fa fa-edit"></i>
                            </router-link>
                            <a class="btn btn-xs btn-danger" v-on:click="destroyUser(user.id)"><i class="fa fa-trash"></i></a>
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
            <pagination 
                :zroute="'userIndex'" 
                :meta="users.paginator"
                :paginateBy="paginateUsers"
                ></pagination>
        </div>
    </div>
`;