import shared from 'belt/core/js/abilities/shared';
import abilityButton from 'belt/core/js/abilities/list-group/ability-button';
import html from 'belt/core/js/abilities/list-group/template.html';

export default {
    mixins: [shared],
    props: ['entity_type'],
    data() {
        return {
            defaultNames: ['create', 'view', 'update', 'delete'],
        }
    },
    computed: {
        canDoEverything() {
            if (!this.everythingAbility) {
                return false;
            }
            return !!this.permissions[this.everythingAbility.id];
        },
        everythingAbility() {
            return _.find(this.abilities, {
                entity_type: this.entity_type,
                name: '*',
            });
        },
        otherNames() {
            let names = [];
            let abilities = this.abilities;
            abilities = _.filter(abilities, {entity_type: this.entity_type});
            _.forEach(abilities, (ability) => {
                if (this.defaultNames.indexOf(ability.name) == -1 && ability.name != '*') {
                    names.push(ability.name);
                }
            });
            return names;
        },
    },
    components: {
        abilityButton
    },
    template: html,
}