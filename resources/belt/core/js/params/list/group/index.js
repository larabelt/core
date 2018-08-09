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
                    zlabel: '',
                    description: null,
                    collapsible: true,
                    collapsed: false,
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
    },
    mounted() {
        if (this.collapsible && _.get(this.group, 'collapsed') === true) {
            this.expanded = false;
        }
    },
    methods: {
        toggle() {
            this.expanded = !this.expanded;
        },
    },
    components: {
        edit: edit,
    },
    template: html
}