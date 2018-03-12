import BaseForm from 'belt/core/js/helpers/form';
import BaseService from 'belt/core/js/helpers/service';
import dateformat from 'dateformat';

class AlertForm extends BaseForm {

    constructor(options = {}) {
        super(options);
        this.service = new BaseService({baseUrl: '/api/v1/alerts/'});
        this.routeEditName = 'alerts.edit';
        this.setData({
            id: '',
            is_active: 1,
            show_url: 0,
            name: '',
            slug: '',
            url: '',
            intro: '',
            body: '',
            starts_at: '',
            starts_at_date: '',
            starts_at_time: '',
            ends_at: '',
            ends_at_date: '',
            ends_at_time: '',
        })
    }

    setData(data) {
        super.setData(data);

        if (this.starts_at) {
            let starts_at = new Date(this.starts_at);
            this.starts_at_date = dateformat(starts_at, "yyyy-mm-dd");
            this.starts_at_time = dateformat(starts_at, "HH:MM");
        }

        if (this.ends_at) {
            let ends_at = new Date(this.ends_at);
            this.ends_at_date = dateformat(ends_at, "yyyy-mm-dd");
            this.ends_at_time = dateformat(ends_at, "HH:MM");
        }
    }

    submit() {
        if (this.starts_at_date && this.starts_at_time) {
            this.starts_at = this.starts_at_date + ' ' + this.starts_at_time + ':00';
        }

        if (this.ends_at_date && this.ends_at_time) {
            this.ends_at = this.ends_at_date + ' ' + this.ends_at_time + ':00';
        }

        super.submit();
    }

}

export default AlertForm;