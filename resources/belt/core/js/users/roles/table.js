import BaseTable from 'belt/core/js/helpers/table';
import BaseService from 'belt/core/js/helpers/service';

class UserRoleTable extends BaseTable {

    constructor(options = {}) {
        super(options);
        let baseUrl = `/api/v1/users/${this.entity_id}/roles/`;
        this.service = new BaseService({baseUrl: baseUrl});
    }

}

export default UserRoleTable;