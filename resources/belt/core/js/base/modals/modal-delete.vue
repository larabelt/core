<template>
    <a class="modal-delete-trigger" :class="_class" @click="remove(itemId)">
        <slot>
            <i class="fa fa-trash"></i>
        </slot>
    </a>
</template>

<script>
    export default {
        computed: {
            parent() {
                if (!this.callingObject) {
                    return this.$parent;
                }

                return this.callingObject;
            }
        },
        created() {
            Events.$on('modal-confirmation', (key) => {
                if (key == this.key) {
                    this.parent.destroy(this.itemId)
                        .then(() => {
                            Events.$emit('modal-delete-confirmed', this.itemId);
                        });
                }
            });
        },
        data() {
            return {
                key: Math.random().toString(36).substr(2),
                modalTemplate: `
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="gridSystemModalLabel">Remove This Item?</h4>
                    </div>
                    <div class="modal-body">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" data-modals="confirmation">Confirm</button>
                    </div>
                `
            }
        },
        methods: {
            remove() {
                Events.$emit('smallModal', {
                    key: this.key,
                    template: this.modalTemplate
                })
            }
        },
        props: {
            _class: {
                default: 'btn btn-xs btn-danger',
            },
            itemId: {
                default: null
            },
            callingObject: {
                default: null
            }
        }
    }

</script>

<style>
    .modal-delete-trigger {
        cursor: pointer;
    }
</style>