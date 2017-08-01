<template>
    <div>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">Large modal</button>

        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content" v-html="largeContent"></div>
            </div>
        </div>

        <!-- Small modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm">Small modal</button>

        <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content" v-html="smallContent"></div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        computed: {
            largeTrigger() {
                return $('.bs-example-modal-lg');
            },
            smallTrigger() {
                return $('.bs-example-modal-sm');
            }
        },
        created() {
            Events.$on('largeModal', (payload) => {
                this.currentKey = typeof payload.key == 'string' ? payload.key : '';
                this.showLargeModal(payload.template);
            });
            Events.$on('smallModal', (payload) => {
                this.currentKey = typeof payload.key == 'string' ? payload.key : '';
                this.showSmallModal(payload.template);
            });
        },
        data() {
            return {
                currentKey: '',
                largeContent: `<div>I am some large content</div>`,
                smallContent: `<div>I am some small content</div>`,
            }
        },
        methods: {
            closeModal() {
                this.largeTrigger.modal('hide');
                this.smallTrigger.modal('hide');
            },
            showLargeModal(content) {
                this.largeContent = content;
                this.largeTrigger.modal('show');
            },
            showSmallModal(content) {
                this.smallContent = content;
                this.smallTrigger.modal('show');
            }
        },
        mounted() {
            $(this.$el).on('click', '[data-modals="confirmation"]', () => {
                Events.$emit('modal-confirmation', this.currentKey);
                this.closeModal();
            });
        }
    }
</script>