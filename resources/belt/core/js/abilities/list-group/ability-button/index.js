import shared from 'belt/core/js/abilities/shared';
import html from 'belt/core/js/abilities/list-group/ability-button/template.html';

export default {
    mixins: [shared],
    props: {
        'entity_type': {
            default: function () {
                return this.$parent.entity_type;
            },
        },
        'name': {},
    },
    computed: {
        _class() {
            return this.isAllowed ? 'btn-primary' : 'btn-default';
        },
        ability() {
            return _.find(this.abilities, {
                entity_type: this.entity_type,
                name: this.name,
            });
        },
        canToggle() {
            return !_.isEmpty(this.ability);
        },
        isAllowed() {
            if (_.isEmpty(this.ability)) {
                return false;
            }
            return !!this.permissions[this.ability.id];
        },
        title() {
            if (this.name == '*') {
                return 'grant all rights for ' + this.entity_type;
            }
            return '';
        }
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