<template>
    <belt-editor
            :form="translation"
            @input="emitEvent"
    >
    </belt-editor>
</template>

<script>
    import BaseTranslationInput from 'belt/core/js/translations/input/Base';

    export default {
        mixins: [BaseTranslationInput],
        mounted() {
            //this.eventBus.$on('fetch-auto-translation', this.fetchAutoTranslation);
        },
        methods: {
            emitEvent(payload) {
                //this.translation.value = payload;
            }
        },
    }
</script>