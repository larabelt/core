<template>
    <div v-if="visible" class="box box-solid box-warning">
        <div class="box-header with-border">
            <span><code>{{ altLocale }}</code></span>
            <span v-if="showAutoTranslate" class="pull-right">
                <button v-if="!loading" class="btn btn-default btn-xs" @click.prevent="fetchAutoTranslation">auto-translate</button>
                <span v-else class="btn btn-default btn-xs"><i class="fa fa-refresh fa-spin"></i></span>
            </span>
        </div>
        <div class="box-body">
            <component :is="inputComponent"></component>
        </div>
    </div>
</template>

<script>
    import BaseInput from 'belt/core/js/inputs/shared';
    import StoreAdapter from 'belt/core/js/translations/store/adapter';
    import TranslationInputEditor from 'belt/core/js/translations/input/editor';
    import TranslationInputText from 'belt/core/js/translations/input/text';
    import TranslationInputTextarea from 'belt/core/js/translations/input/textarea';

    export default {
        mixins: [BaseInput, StoreAdapter],
        props: {
            type: {
                type: String,
                default: function () {
                    return 'text';
                }
            },
        },
        data() {
            return {
                eventBus: new Vue(),
                loading: false,
            }
        },
        created() {
            Events.$on(this.parentUpdateEvent, this.update);
            this.eventBus.$on('updated', this.updated);
        },
        computed: {
            inputComponent() {
                if (this.type == 'editor') {
                    return 'TranslationInputEditor'
                }
                if (this.type == 'textarea') {
                    return 'TranslationInputTextarea'
                }
                return 'TranslationInputText';
            },
            showAutoTranslate() {
                return this.canAutoTranslate && !this.form.dirty(this.column);
            },
            translatable() {
                return this.form.id ? Vue.prototype.translatable(this.form, this.column) : false;
            },
            visible() {
                return this.translatable && this.translationsVisible;
            },
        },
        methods: {
            fetchAutoTranslation() {
                this.loading = true;
                this.eventBus.$emit('fetch-auto-translation');
            },
            update() {
                this.eventBus.$emit('update');
            },
            updated() {
                this.loading = false;
            },
        },
        components: {
            TranslationInputEditor,
            TranslationInputText,
            TranslationInputTextarea,
        },
    }
</script>