import baseInput from 'belt/core/js/inputs/shared';
import storeAdapter from 'belt/core/js/translations/store/adapter';
import html from 'belt/core/js/translations/inputs/addon/template.html';

export default {
    mixins: [baseInput, storeAdapter],
    methods: {
        toggle() {
            this.toggleTranslationsVisibility(this.column);
        }
    },
    template: html
}