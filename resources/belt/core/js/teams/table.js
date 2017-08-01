import BaseTable from 'belt/core/js/helpers/table';
import BaseService from 'belt/core/js/helpers/service';

class TeamTable extends BaseTable {

    constructor(options = {}) {
        super(options);
        this.service = new BaseService({baseUrl: '/api/v1/teams/'});
    }

}

export default TeamTable;