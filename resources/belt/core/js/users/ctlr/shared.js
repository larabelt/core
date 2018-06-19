import access from 'belt/core/js/access/shared';

export default {
    mixins: [access],
    created() {
        this.authCan('attach', 'roles');
    },
    computed: {
        authCanAttachRoles() {
            return _.get(this.authAccess, 'roles.attach');
        }
    },
}