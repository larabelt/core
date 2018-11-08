<template>
    <span>
        <template v-if="!alert">
            <button
                    class="btn btn-default btn-xs"
                    @click.prevent="trash"
            ><i class="fa fa-trash"></i>
            </button>
        </template>
        <template v-else>
            <div class="btn-group">
                <button
                        class="btn btn-xs btn-danger"
                        @click.prevent="confirm"
                ><i class="fa fa-trash"></i></button>
                <button
                        class="btn btn-xs btn-default"
                        @click.prevent="cancel"
                ><i class="fa fa-undo"></i></button>
            </div>
        </template>
    </span>
</template>

<script>
    import shared from 'belt/core/js/button/shared';

    export default {
        mixins: [shared],
        data() {
            return {
                alert: false,
            }
        },
        computed: {
            buttonClass() {
                return this.translationsVisible ? 'btn-warning' : 'btn-default';
            },
        },
        methods: {
            cancel() {
                this.alert = false;
            },
            confirm() {
                this.$emit('trash');
                this.alert = false;
            },
            trash() {
                this.alert = true;
            },

        },
    }
</script>