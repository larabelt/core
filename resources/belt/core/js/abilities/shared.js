export default {
    props: {
        'storeKey': {
            default: function () {
                return this.$parent.storeKey;
            }
        }
    },
    computed: {
        abilities() {
            return this.$store.getters['abilities/data'];
        },
        entityAbilities() {
            let abilities = _.reject(this.abilities, {'entity_type': null});
            abilities = _.reject(abilities, {'entity_type': '*'});
            return abilities;
        },
        nonEntityAbilities() {
            let abilities = _.filter(this.abilities, {'entity_type': null});
            abilities = _.reject(abilities, {'entity_type': '*'});
            return abilities;
        },
        abilitiesByEntityType() {
            let abilities = _.uniqBy(this.abilities, 'entity_type');
            abilities = _.sortBy(abilities, [function (o) {
                let sort = o.entity_type ? o.entity_type : 1;
                return sort;
            }]);
            abilities = _.reject(abilities, {'entity_type': '*'});
            return abilities;
        },
        isSuper() {
            if (!this.superAbility) {
                return false;
            }
            return !!this.permissions[this.superAbility.id];
        },
        permissions() {
            return this.$store.getters[this.storeKey + '/permissions/data'];
        },
        superAbility() {
            return _.find(this.abilities, {
                entity_type: '*',
                name: '*',
            });
        },
    },
}