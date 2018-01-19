import Cookies from 'belt/core/js/helpers/cookies';
import html from 'belt/core/js/alerts/ctlr/dismissal/template.html';

export default {
    props: {
        alert: {},
        class: {},
        id: {},
    },
    data() {
        return {
            show: true,
        }
    },
    computed: {
        _alert() {
            return JSON.parse(this.alert);
        },
        _class() {
            return this.class ? this.class : 'alert alert-warning';
        },
        _id() {
            return this.id ? this.id : 'alert-' + this.alert.id;
        },
    },
    methods: {
        dismiss() {

            this.show = false;

            let id = this._alert.id;

            // Emit event to parent component
            this.$emit('alert-dismissed', id);

            let ids = [];
            const existingIds = (new Cookies()).get('alerts');

            if (existingIds) {
                ids = existingIds.split(',');
            }

            ids.push(id);
            ids = _.compact(_.uniq(ids));
            ids = ids.join(',');

            let cookie = new Cookies();
            cookie.set('alerts', ids, 7);
        },
    },
    template: html,
}