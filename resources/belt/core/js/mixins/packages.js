export default {
    data() {
        return {
            beltPackages: {
                'spot': [
                    'deals',
                    'events',
                    'places',
                ]
            },
        }
    },
    methods: {
        type2Package(type) {
            let beltPackage = _.findKey(this.beltPackages, function (o) {
                return _.includes(o, type);
            });

            return beltPackage ? beltPackage : 'core';
        },
    },
}