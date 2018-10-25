export default {
    props: {
        form: {
            type: Object,
            default: function () {
                return this.$parent.form;
            }
        },
    },
}