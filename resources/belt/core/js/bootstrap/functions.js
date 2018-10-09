Vue.prototype.can = (ability, model) => {

    if (_.get(window.larabelt.access, model + '.*')) {
        return true;
    }

    return _.get(window.larabelt.access, model + '.' + ability) ? true : false;
};

Vue.prototype.toTitleCase = (str) => {
    str = str.replace(/_/g, ' ');
    str = str.replace(/-/g, ' ');
    return str.replace(
        /\w\S*/g,
        function (txt) {
            return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
        }
    );
};

Vue.prototype.trans = (string, args) => {

    string = string.replace('::', '.');

    let value = _.get(window.i18n, string);

    _.eachRight(args, (paramVal, paramKey) => {
        value = _.replace(value, `:${paramKey}`, paramVal);
    });

    return value;
};

// Vue.prototype.disable = (form, attribute) => {
//
//     if (!_.get(window, 'larabelt.alt-locale')) {
//         return false;
//     }
//
//     let translatable = _.get(form, 'config.translatable');
//
//     if (translatable === true) {
//         return false;
//     }
//
//     if (_.includes(translatable, attribute)) {
//         return false;
//     }
//
//     return true;
// };

/**
 * null == doesn't matter
 * true == can be translated
 * false == cannot be translated
 * @param form
 * @param attribute
 * @returns {boolean}
 */
Vue.prototype.translatable = (form, attribute) => {

    if (!_.get(window, 'larabelt.alt-locale')) {
        return true;
    }

    let translatable = _.get(form, 'config.translatable');

    if (translatable === true) {
        return true;
    }

    if (_.includes(translatable, attribute)) {
        return true;
    }

    return false;
};