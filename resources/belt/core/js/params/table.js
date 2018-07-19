import BaseTable from 'belt/core/js/helpers/table';
import BaseService from 'belt/core/js/helpers/service';

class ParamTable extends BaseTable {

    constructor(options = {}) {
        super(options);
        let baseUrl = `/api/v1/${this.entity_type}/${this.entity_id}/params/`;
        this.service = new BaseService({baseUrl: baseUrl});
        this.query.perPage = 0;
    }

}

export default ParamTable;