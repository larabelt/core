Vue.prototype.trans = (string, args) => {

    string = string.replace('::', '.');

    let value = _.get(window.i18n, string);

    _.eachRight(args, (paramVal, paramKey) => {
        value = _.replace(value, `:${paramKey}`, paramVal);
    });

    return value;
};

Vue.prototype.can = (ability, model) => {

    if (_.get(window.larabelt.access, model + '.*')) {
        return true;
    }

    return _.get(window.larabelt.access, model + '.' + ability) ? true : false;
};