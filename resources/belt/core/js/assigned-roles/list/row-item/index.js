import mixin from 'belt/core/js/assigned-roles/list/mixin';
import html from 'belt/core/js/assigned-roles/list/row-item/template.html';

export default {
    mixins: [mixin],
    props: {
        'role': {
            default: function () {
                return this.$parent.role;
            }
        },
        'storeKey': {
            default: function () {
                return this.$parent.storeKey;
            }
        },
    },
    mounted() {
    },
    computed: {
        hasRole() {
            return _.find(this.assignedRoles, {
                id: this.role.id
            });
        },
        _class() {
            return this.isAllowed ? 'btn-primary' : 'btn-default';
        },
    },
    methods: {
        assign() {
            this.$store.dispatch(this.storeKey + '/roles/assign', this.role.id);
        },
        retract() {
            this.$store.dispatch(this.storeKey + '/roles/retract', this.role.id);
        },
        toggle() {
            if (this.hasRole) {
                this.retract();
            } else {
                this.assign();
            }
        },
    },
    template: html
}