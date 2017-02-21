import BaseForm from 'belt/core/js/helpers/form';
import BaseService from 'belt/core/js/helpers/service';

class RoleForm extends BaseForm {

    constructor(options = {}) {
        super(options);
        this.service = new BaseService({baseUrl: '/api/v1/roles/'});
        this.routeEditName = 'roles.edit';
        this.setData({
            id: '',
            name: '',
            slug: '',
        })
    }

}

export default RoleForm;