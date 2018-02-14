import BaseTable from 'belt/core/js/helpers/table';
import BaseService from 'belt/core/js/helpers/service';

class Table extends BaseTable {

    setService(entityType, entityID) {
        this.service = new BaseService({
            baseUrl: `/api/v1/${entityType}/${entityID}/roles/`
        });
    }

}

export default Table;