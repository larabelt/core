import BaseForm from 'belt/core/js/helpers/form';
import BaseService from 'belt/core/js/helpers/service';

class Form extends BaseForm {

    constructor(options = {}) {
        super(options);
        let baseUrl = `/api/v1/${this.entity_type}/${this.entity_id}/params/`;
        this.service = new BaseService({baseUrl: baseUrl});

        this.setData({
            id: '',
            key: options.key ? options.key : '',
            value: '',
        });
    }

}

export default Form;