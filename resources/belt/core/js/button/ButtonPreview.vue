<template>
    <a v-if="form.id" class="btn btn-sm btn-default" target="_blank" :href="href">preview</a>
</template>

<script>
    import shared from 'belt/core/js/button/shared';

    export default {
        mixins: [shared],
        props: {
            href: {
                type: String,
                default: function () {
                    return '/' + this.form.morph_class + '/' + this.form.id;
                }
            },
        },
        computed: {
            alignment() {
                this.align == 'left' ? 'pull-right' : 'pull-left';
            }
        }
    }
</script>