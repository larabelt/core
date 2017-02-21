import BaseTable from 'belt/core/js/helpers/table';
import BaseService from 'belt/core/js/helpers/service';

class TeamUserTable extends BaseTable {

    constructor(options = {}) {
        super(options);
        let baseUrl = `/api/v1/teams/${this.morphable_id}/users/`;
        this.service = new BaseService({baseUrl: baseUrl});
    }

}

export default TeamUserTable;