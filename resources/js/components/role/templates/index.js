export default `
    <div class="box box-primary">
        <div class="box-body">
            <div class="btn-group">
                <router-link to="/roles/create" v-bind:class="'btn btn-primary'">add role</router-link>
            </div>
            <table class="table table-bordered table-hover">
            
                <thead>
                    <tr>
                        <th>
                            ID
                            <column-sorter :route="'roleIndex'" :paginator="roles.paginator" :order-by="'roles.id'"></column-sorter>
                        </th>
                        <th>
                            Name
                            <column-sorter :route="'roleIndex'" :paginator="roles.paginator" :order-by="'roles.name'"></column-sorter>
                        </th>
                        <th>
                            Slug
                            <column-sorter :route="'roleIndex'" :paginator="roles.paginator" :order-by="'roles.slug'"></column-sorter>
                        </th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
    
                <tbody>                
                    <tr v-for="role in roles.roles">
                        <td>{{ role.id }}</td>
                        <td>{{ role.name }}</td>
                        <td>{{ role.slug }}</td>
                        <td class="text-right">
                            <router-link :to="{ name: 'roleEdit', params: { id: role.id } }" v-bind:class="'btn btn-xs btn-warning'">
                                <i class="fa fa-edit"></i>
                            </router-link>
                            <a class="btn btn-xs btn-danger" v-on:click="destroyRole(role.id)"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                </tbody>
    
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </tfoot>
                
            </table>
            <pagination :route="'roleIndex'" :paginator="roles.paginator"></pagination>
        </div>
    </div>
`;