import shared from 'belt/core/js/inputs/shared';
import inputAddonTranslatable from 'belt/core/js/translations/inputs/addon';
import inputGroupTranslations from 'belt/core/js/translations/inputs/group';
import html from 'belt/core/js/inputs/text/template.html';

export default {
    mixins: [shared],
    computed: {
        hasInputGroups() {
            return this.translatable;
        },
    },
    components: {
        inputAddonTranslatable,
        inputGroupTranslations,
    },
    template: html
}