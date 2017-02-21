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

        let baseUrl = `/api/v1/users/${this.morphable_id}/roles/`;

        this.service = new BaseService({baseUrl: baseUrl});
        this.routeEditName = 'users.roles';
        this.setData({
            id: '',
        });
    }

}

export default Form;