import workRequest from 'belt/core/js/work-requests/store/mixin';

export default {
    mixins: [workRequest],
    props: {
        work_request_id: null,
        work_request_data: {},
    },
}