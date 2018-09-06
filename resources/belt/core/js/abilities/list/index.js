import shared from 'belt/core/js/abilities/shared';
import listGroup from 'belt/core/js/abilities/list-group';
import listItem from 'belt/core/js/abilities/list-item';
import abilityButton from 'belt/core/js/abilities/list-group/ability-button';
import html from 'belt/core/js/abilities/list/template.html';

export default {
    mixins: [shared],
    props: ['storeKey'],
    computed: {
        abilityEntityTypes() {
            let entities = [];
            _.forEach(this.abilitiesByEntityType, function (ability) {
                if (ability.entity_type) {
                    entities.push(ability.entity_type);
                }
            });
            return entities;
        },
        entityChunks() {
            let count = _.ceil(this.abilityEntityTypes.length / 2);
            return _.chunk(this.abilityEntityTypes, count)
        },
        nonEntityChunks() {
            let count = _.ceil(this.nonEntityAbilities.length / 2);
            return _.chunk(this.nonEntityAbilities, count)
        },
    },
    components: {
        abilityButton,
        listGroup,
        listItem,
    },
    template: html
}