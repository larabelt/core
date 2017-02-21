export default `
    <div class="row">
        <div class="col-md-12">
            <form role="form" class="form-inline">
                <div class="form-group">
                    <input type="text" class="form-control" v-model.trim="query.q" v-on:keyup="paginateNot()" placeholder="search">
                </div>
            </form>
            <table v-if="items" class="table table-striped table-condensed table-hover">
                <tbody>                
                    <tr v-for="user in detached">
                        <td>{{ user.email }}</td>
                        <td class="text-right">
                            <a class="btn btn-xs btn-primary" v-on:click="attach(user.id)"><i class="fa fa-link"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-12">
           <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>
                            Email
                            <column-sorter :column="'users.email'"></column-sorter>
                        </th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>                
                    <tr v-for="user in attached">
                        <td>{{ user.email }}</td>
                        <td class="text-right">
                            <a class="btn btn-xs btn-danger" v-on:click="detach(user.id)"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <pagination></pagination>
        </div>
    </div>
`;