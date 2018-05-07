import BaseForm from 'belt/core/js/helpers/form';
import BaseService from 'belt/core/js/helpers/service';

class TeamForm extends BaseForm {

    constructor(options = {}) {
        super(options);
        this.service = new BaseService({baseUrl: '/api/v1/teams/'});
        this.routeEditName = 'teams.edit';
        this.setData({
            id: '',
            default_user_id: null,
            is_active: false,
            name: '',
            slug: '',
            body: '',
        })
    }

}

export default TeamForm;