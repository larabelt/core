<template>
    <button class="btn btn-default btn-sm" @click.prevent="toggleTranslationsVisibility">
        translate
    </button>
</template>

<script>
    import shared from 'belt/core/js/button/shared';
    import translatable from 'belt/core/js/translations/store/adapter';

    export default {
        mixins: [shared, translatable],
        // props: {
        //     translatable_type: {
        //         type: String,
        //         default: function () {
        //             return this.form.morph_class;
        //         }
        //     },
        //     translatable_id: {
        //         type: Number,
        //         default: function () {
        //             return this.form.id;
        //         }
        //     },
        // },
        computed: {
            translatable_type() {
                return this.form.morph_class;
            },
            translatable_id() {
                return this.form.id;
            },
        },
    }
</script>