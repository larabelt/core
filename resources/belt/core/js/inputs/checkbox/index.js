import shared from 'belt/core/js/inputs/shared';
import html from 'belt/core/js/inputs/checkbox/template.html';

export default {
    mixins: [shared],
    props: {
        falseValue: {default: false},
        trueValue: {default: true},
    },
    template: html
}