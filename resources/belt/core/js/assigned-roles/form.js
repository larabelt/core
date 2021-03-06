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
        this.setData({
            id: '',
            name: '',
            title: '',
            description: '',
            level: '',
            scope: '',
        });
    }

    setService(entityType, entityID) {
        this.service = new BaseService({
            baseUrl: `/api/v1/${entityType}/${entityID}/roles/`
        });
    }

}

export default Form;