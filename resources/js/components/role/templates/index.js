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
                            <column-sorter :routename="'roleIndex'" :order-by="'roles.id'"></column-sorter>
                        </th>
                        <th>
                            Name
                            <column-sorter :routename="'roleIndex'" :order-by="'roles.name'"></column-sorter>
                        </th>
                        <th>
                            Slug
                            <column-sorter :routename="'roleIndex'" :order-by="'roles.slug'"></column-sorter>
                        </th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
    
                <tbody>                
                    <tr v-for="item in items.data">
                        <td>{{ item.id }}</td>
                        <td>{{ item.name }}</td>
                        <td>{{ item.slug }}</td>
                        <td class="text-right">
                            <router-link :to="{ name: 'roleEdit', params: { id: item.id } }" v-bind:class="'btn btn-xs btn-warning'">
                                <i class="fa fa-edit"></i>
                            </router-link>
                            <a class="btn btn-xs btn-danger" v-on:click="destroy(item.id)"><i class="fa fa-trash"></i></a>
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
            <pagination :routename="'roleIndex'"></pagination>
        </div>
    </div>
`;