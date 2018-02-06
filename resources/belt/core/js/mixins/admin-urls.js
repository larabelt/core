import packages from 'belt/core/js/mixins/packages';

export default {
    mixins: [packages],
    methods: {
        adminEditUrl(id, type) {
            let compiled = _.template('/admin/belt/${beltPackage}/${type}/edit/${id}');
            return compiled({
                beltPackage: this.type2Package(type),
                type: this.item.indexable_type,
                id: this.item.indexable_id,
            });
        },
    },
}