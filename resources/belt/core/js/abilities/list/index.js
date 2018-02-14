import shared from 'belt/core/js/abilities/shared';
import abilityGroup from 'belt/core/js/abilities/list-item';
import abilityButton from 'belt/core/js/abilities/list-item/ability-button';
import html from 'belt/core/js/abilities/list/template.html';

export default {
    mixins: [shared],
    props: ['storeKey'],
    computed: {
        chunks() {
            let count = _.ceil(this.abilitiesByEntityType.length / 2);
            return _.chunk(this.abilitiesByEntityType, count)
        }
    },
    components: {
        abilityButton,
        abilityGroup,
    },
    template: html
}