import shared from 'belt/core/js/inputs/shared';
import inputAddonTranslatable from 'belt/core/js/translations/inputs/addon';
import inputGroupTranslations from 'belt/core/js/translations/inputs/group';
import inputTranslateTextarea from 'belt/core/js/translations/inputs/textarea';
import html from 'belt/core/js/inputs/textarea/template.html';

export default {
    mixins: [shared],
    components: {
        inputAddonTranslatable,
        inputGroupTranslations,
        inputTranslateTextarea,
    },
    template: html
}