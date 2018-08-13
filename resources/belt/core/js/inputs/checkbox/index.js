import shared from 'belt/core/js/inputs/shared';
import html from 'belt/core/js/inputs/checkbox/template.html';

export default {
    mixins: [shared],
    computed: {
        options() {
            let options = [];
            let config = _.get(this.config, 'options', {});
            if (!_.isEmpty(config)) {
                _.forIn(config, function (value, key) {
                    options.push({
                        value: key,
                        label: value,
                    });
                });
                options = _.orderBy(options, ['label']);
            }
            return options;
        },
    },
    template: html
}