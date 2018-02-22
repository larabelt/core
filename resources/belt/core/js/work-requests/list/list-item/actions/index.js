import workRequest from 'belt/core/js/work-requests/store/mixin';
import html from 'belt/core/js/work-requests/list/list-item/actions/template.html';

export default {
    mixins: [workRequest],
    props: {
        work_request_id: null,
        work_request_data: {},
    },
    mounted() {
        //this.workRequest.setData(this.work_request_data);
    },
    methods: {
        submit(key) {
            this.workRequest.transition = key;
            this.workRequest.submit()
                .then(() => {
                    this.$store.dispatch(this.storeKey + '/load', this.work_request_id);
                    let workableStoreKey = this.workRequest.workable_type + this.workRequest.workable_id;
                    if (this.$store.state[workableStoreKey]) {
                        this.$store.dispatch(workableStoreKey + '/load', this.workRequest.workable_id);
                    }
                });
        },
    },
    template: html,
}