import edit from 'belt/core/js/translations/edit';
import html from 'belt/core/js/translations/list/group/template.html';

export default {
    props: {
        groupKey: {
            default: function () {
                return '';
            }
        },
        group: {
            default: function () {
                return {
                    description: null,
                    collapsible: true,
                    collapsed: false,
                    component: null,
                }
            }
        },
        translations: {
            default: function () {
                return [];
            }
        }
    },
    data() {
        return {
            expanded: true,
            eventBus: this.$parent.eventBus,
            translatable_type: this.$parent.translatable_type,
            translatable_id: this.$parent.translatable_id,
        }
    },
    computed: {
        collapsible() {
            return _.get(this.group, 'collapsible', true);
        },
        description() {
            return _.get(this.group, 'description');
        },
        label() {
            let label = _.get(this.group, 'label');

            // if (!label) {
            //     _.each(this.translations, (translation) => {
            //         label = _.get(translation, 'config.label')
            //     })
            // }

            return label ? label : this.toTitleCase(this.groupKey);
        },
        customGroupComponent() {
            let componentName = 'translation-group-' + this.group.component;
            return _.has(Vue.options.components, componentName) ? componentName : null;
        },
    },
    mounted() {
        if (this.collapsible) {
            if (History.has('translation.collapsed', this.groupKey)) {
                this.expanded = History.get('translation.collapsed', this.groupKey);
            } else {
                this.expanded = !_.get(this.group, 'collapsed', false);
            }
        }
    },
    methods: {
        toggle() {
            this.expanded = !this.expanded;
            History.set('translation.collapsed', this.groupKey, this.expanded);
        },
    },
    components: {
        edit: edit,
    },
    template: html
}