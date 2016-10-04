export default `
<div class="box box-primary">
    <div class="box-body">
        <div class="btn-group">
            <router-link to="/roles/create" v-bind:class="'btn btn-primary'">add role</router-link>
        </div>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th v-for="column in items.columns">
                        {{ column.title }} 
                        <column-sorter :order-by="items.slug + '.' + column.slug" :routename="'roleIndex'"></column-sorter>
                    </th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>

            <tbody>                
                <tr v-for="item in items.data.data">
                    <td v-for="column in items.columns">{{ item[column.slug] }}</td>
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
                    <th v-for="column in items.columns">{{ column.title }}</th>
                </tr>
            </tfoot>
        </table>
        <div class="row">
            <div class="col-xs-5">
                <div class="dataTables_info" role="status" aria-live="polite">
                    Showing {{ items.data.from }} to {{ items.data.to }} of {{ items.data.total }} entries
                </div>
            </div>
            <div class="col-xs-7">
                <pagination :routename="'roleIndex'"></pagination>
            </div>
        </div>
    </div>
</div>

`;