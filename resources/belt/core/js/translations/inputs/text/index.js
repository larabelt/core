import Form from 'belt/core/js/translations/form';
import html from 'belt/core/js/translations/inputs/text/template.html';

export default {
    props: {
        translation: {
            default: function () {
                return {};
            }
        },
    },
    data() {
        return {
            checked: false,
            eventBus: this.$parent.eventBus,
        }
    },
    computed: {
        dirty() {
            return this.translation.dirty('value');
        },
    },
    mounted() {
        this.eventBus.$on('update', () => {
            this.update();
        });
    },
    methods: {
        update() {
            if (this.dirty && (this.translation.id || this.translation.value)) {
                this.translation.submit();
            }
        },
    },
    template: html,
}