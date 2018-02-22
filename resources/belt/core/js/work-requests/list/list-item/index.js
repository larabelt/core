import workRequest from 'belt/core/js/work-requests/store/mixin';
import datetime from 'belt/core/js/mixins/datetime';
import actions from 'belt/core/js/work-requests/list/list-item/actions';
import html from 'belt/core/js/work-requests/list/list-item/template.html';

export default {
    mixins: [workRequest, datetime],
    props: {
        work_request_id: null,
        work_request_data: {},
    },
    computed: {
        editUrl() {
            return _.get(this.workRequest, 'workflow.workable.editUrl');
        },
        editUrl() {
            return _.get(this.workRequest, 'workflow.workable.editUrl');
        },
    },
    mounted() {
        this.workRequest.setData(this.work_request_data);
    },
    components: {
        actions,
    },
    template: html,
}