export default {
    computed: {
        auth() {
            return window.larabelt.auth;
        },
        activeTeam() {
            return window.larabelt.activeTeam;
        },
        adminMode() {
            return window.larabelt.adminMode;
        }
    },
}