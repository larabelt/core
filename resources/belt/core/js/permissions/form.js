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
            ability_id: null,
            entity_type: null,
            entity_id: null,
            forbidden: 0,
            scope: null,
        });
    }

    setService(entityType, entityID) {
        this.service = new BaseService({
            baseUrl: `/api/v1/${entityType}/${entityID}/permissions/`
        });
    }

}

export default Form;