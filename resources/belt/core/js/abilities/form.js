import BaseForm from 'belt/core/js/helpers/form';
import BaseService from 'belt/core/js/helpers/service';

class Form extends BaseForm {

    /**
     * Create a new Form instance.
     *
     * @param {object} options
     */
    constructor(options = {}) {
        super(options);
        this.service = new BaseService({
            baseUrl: `/api/v1/abilities/`
        });
        this.setData({
            name: '',
            title: '',
            entity_type: '',
            entity_id: '',
            only_owned: '',
            scope: '',
        });
    }

}

export default Form;