function getParentProp(value) {
    return {
        type: String,
        default: function () {
            return this.$parent[value];
        }
    }
}

function getParentValue(value) {
    return function () {
        return this.$parent[value];
    };
}

export function mapParentValues(values) {

    let functions = {};

    _.each(values, (value) => {
        functions[value] = getParentValue(value);
    });

    return functions;
}

export function mapParentProps(values) {

    let props = {};

    _.each(values, (value) => {
        props[value] = getParentProp(value);
    });

    return props;
}

export const Example = {
    computed: {
        hello() {
            return 'world';
        }
    },
};

export default {mapParentValues, mapParentProps, Example}