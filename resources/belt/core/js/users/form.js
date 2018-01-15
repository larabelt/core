import BaseForm from 'belt/core/js/helpers/form';
import BaseService from 'belt/core/js/helpers/service';

class UserForm extends BaseForm {

    constructor(options = {}) {
        super(options);
        this.service = new BaseService({baseUrl: '/api/v1/users/'});
        this.routeEditName = 'users.edit';
        this.setData({
            id: '',
            is_active: 0,
            is_opted_in: 0,
            first_name: '',
            last_name: '',
            mi: '',
            email: '',
            password: '',
            password_confirmation: '',
        })
    }

    setData(data) {
        data['password'] = '';
        data['password_confirmation'] = '';
        super.setData(data);
    }

}

export default UserForm;