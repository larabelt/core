import Form from 'belt/core/js/translations/form';
import html from 'belt/core/js/translations/inputs/text/template.html';

export default {
    props: {
        config: {
            default: function () {
                return {};
            }
        },
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
            form: new Form({entity_type: this.$parent.translatable_type, entity_id: this.$parent.translatable_id}),
        }
    },
    computed: {
        dirty() {
            return this.form.dirty('value');
        },
    },
    watch: {
        'translation.id': function () {
            this.reset();
        }
    },
    mounted() {
        this.eventBus.$on('update', () => {
            this.update();
        });
        this.reset();
    },
    methods: {
        reset() {
            this.form.reset();
            this.form.setData(this.translation);
        },
        update() {
            if (this.dirty) {
                this.form.submit();
            }
        },
    },
    template: html
}