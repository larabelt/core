import BaseForm from 'belt/core/js/helpers/form';
import BaseService from 'belt/core/js/helpers/service';

class Form extends BaseForm {

    constructor(options = {}) {
        super(options);
        this.service = new BaseService({baseUrl: '/api/v1/work-requests/'});
        this.routeEditName = 'work-requests.edit';
        this.setData({
            id: '',
            workable_id: null,
            workable_type: null,
            workflow_key: null,
            place: null,
            transition: '',
            payload: {},
            workflow: {},
        })
    }

    /**
     * Set all relevant data for the form.
     */
    setData(data) {
        data.transition = data.transition ? data.transition : '';
        super.setData(data);
    }

}

export default Form;