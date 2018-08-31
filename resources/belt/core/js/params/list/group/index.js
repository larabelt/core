import edit from 'belt/core/js/params/edit';
import html from 'belt/core/js/params/list/group/template.html';

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
        params: {
            default: function () {
                return [];
            }
        }
    },
    data() {
        return {
            expanded: true,
            eventBus: this.$parent.eventBus,
            paramable_type: this.$parent.paramable_type,
            paramable_id: this.$parent.paramable_id,
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
            return _.get(this.group, 'label', 'Param Group');
        },
        customGroupComponent() {
            let componentName = 'param-group-' + this.group.component;
            return _.has(Vue.options.components, componentName) ? componentName : null;
        },
    },
    mounted() {
        if (this.collapsible && _.get(this.group, 'collapsed') === true) {
            this.expanded = History.get('param.collapsed', this.groupKey) ? History.get('param.collapsed', this.groupKey) : false;
        }
    },
    methods: {
        toggle() {
            this.expanded = !this.expanded;
            History.set('param.collapsed', this.groupKey, this.expanded);
        },
    },
    components: {
        edit: edit,
    },
    template: html
}