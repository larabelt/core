import shared from 'belt/core/js/abilities/shared';
import abilityButton from 'belt/core/js/abilities/list-item/ability-button';
import html from 'belt/core/js/abilities/list-item/template.html';

export default {
    mixins: [shared],
    props: ['ability'],
    components: {
        abilityButton
    },
    template: html,
}