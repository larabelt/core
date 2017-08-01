import BaseTable from 'belt/core/js/helpers/table';
import BaseService from 'belt/core/js/helpers/service';

class ParamTable extends BaseTable {

    constructor(options = {}) {
        super(options);
        this.service = new BaseService({baseUrl: '/api/v1/param-values'});
    }

}

export default ParamTable;