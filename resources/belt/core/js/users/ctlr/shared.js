import access from 'belt/core/js/access/shared';

export default {
    mixins: [access],
    created() {
        this.authCan('attach', 'roles');
        this.authCan('view', 'users');
    },
    computed: {
        authCanAttachRoles() {
            return _.get(this.authAccess, 'roles.attach');
        },
        authCanViewUsers() {
            return _.get(this.authAccess, 'view.users');
        },
    },
}