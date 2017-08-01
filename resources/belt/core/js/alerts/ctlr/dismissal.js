import Cookies from 'belt/core/js/helpers/cookies';

export default {
    props: {
        id: {},
    },
    methods: {
        dismiss() {
            // Emit event to parent component
            this.$emit('alert-dismissed', this.id)

            let ids = []
            const existingIds = (new Cookies()).get('alerts');
            
            if (existingIds) {
              ids = existingIds.split(',');
            }

            ids.push(this.id.toString());
            ids = _.compact(_.uniq(ids));
            ids = ids.join(',');
            
            let cookie = new Cookies();
            cookie.set('alerts', ids, 7);
        },
    },
    template: `<div @click="dismiss"><slot></slot></div>`
}