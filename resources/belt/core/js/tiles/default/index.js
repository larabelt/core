import html from 'belt/core/js/tiles/default/template.html';

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
            return _.get(this.item, 'attachments', []);
        },
        image() {
            return _.find(this.attachments, {
                is_image: true,
            });
        },
        name() {
            return _.get(this.item, 'name', _.get(this.item, 'title', ''));
        },
        params() {
            return _.get(this.item, 'params', []);
        },
        summary() {
            let content = _.get(this.item, 'body', _.get(this.item, 'intro', _.get(this.item, 'meta_description', '')));

            if (content.length > 100) {
                content = content.substring(0, 100) + '...';
            }

            return content.replace(/<\/?[^>]+(>|$)/g, "");
        },
        template() {
            return _.get(this.item, 'template', '');
        },
    },
    template: html,
}