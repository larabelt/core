import shared from 'belt/core/js/abilities/shared';
import html from 'belt/core/js/abilities/list-item/ability-button/template.html';

export default {
    mixins: [shared],
    props: ['ability', 'name'],
    computed: {
        _class() {
            return this.isAllowed ? 'btn-primary' : 'btn-default';
        },
        isAllowed() {
            if (_.isEmpty(this.ability)) {
                return false;
            }
            return !!this.permissions[this.ability.id];
        },
    },
    methods: {
        allow() {
            this.$store.dispatch(this.storeKey + '/permissions/allow', {ability_id: this.ability.id});
        },
        disallow() {
            this.$store.dispatch(this.storeKey + '/permissions/disallow', {ability_id: this.ability.id});
        },
        toggle() {
            if (this.isAllowed) {
                this.disallow();
            } else {
                this.allow();
            }
        },
    },
    template: html
}