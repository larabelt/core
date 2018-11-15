import shared from 'belt/core/js/inputs/shared';
import TranslationInputGroup from 'belt/core/js/translations/input/Group';
import html from 'belt/core/js/inputs/textarea/template.html';

export default {
    mixins: [shared],
    components: {
        TranslationInputGroup,
    },
    template: html
}