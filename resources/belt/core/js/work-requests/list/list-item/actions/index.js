import workRequest from 'belt/core/js/work-requests/store/mixin';
import html from 'belt/core/js/work-requests/list/list-item/actions/template.html';

export default {
    mixins: [workRequest],
    props: {
        work_request_id: null,
        work_request_data: {},
    },
    data() {
        return {
            table: this.$parent.table,
        }
    },
    methods: {
        update(key) {
            this.workRequest.transition = key;
            this.submit();
        },
        reset(key) {
            this.workRequest.reset = true;
            this.submit();
        },
        submit() {
            let open = this.workRequest.is_open;
            this.workRequest.submit()
                .then(() => {

                    this.$store.dispatch(this.storeKey + '/load', this.work_request_id)
                        .then(() => {
                            if (open != this.workRequest.is_open) {
                                this.table.index();
                            }
                        });

                    // reload workable store if registered
                    let workableStoreKey = this.workRequest.workable_type + this.workRequest.workable_id;
                    if (this.$store.state[workableStoreKey]) {
                        this.$store.dispatch(workableStoreKey + '/load', this.workRequest.workable_id);
                    }
                });
        }
    },
    template: html,
}