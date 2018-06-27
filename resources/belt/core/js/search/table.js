import BaseTable from 'belt/core/js/helpers/table';

class Table extends BaseTable {

    constructor(options = {}) {
        options.baseUrl = `/api/v1/index/`;
        super(options);
        this.query.perPage = 12;
        this.query.type = '';
    }

}

export default Table;