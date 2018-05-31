import html from 'belt/core/js/base/tile/template.html';

export default {
    props: {
        'item': {
            default: function () {
                return this.$parent.item;
            },
        }
    },
    computed: {
        attachments() {
            return _.get(this.item, 'attachments');
        },
        image() {
            return _.find(this.attachments, {
                is_image: true,
            });
        },
        name() {
            return _.get(this.item, 'name', _.get(this.item, 'title'));
        },
    },
    template: html,
}