import shared from 'belt/core/js/work-requests/list-workable/list-item/shared';
import html from 'belt/core/js/work-requests/list-workable/list-item/action/template.html';

export default {
    mixins: [shared],
    props: {
        label: '',
        transition: {},
    },
    methods: {
        submit() {
            this.workRequest.transition = this.label;
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