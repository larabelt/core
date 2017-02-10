<template>
    <a class="btn btn-xs btn-danger" v-on:click="remove(itemId)"><i class="fa fa-trash"></i></a>
</template>

<script>
    export default {
        created() {
            Events.$on('modal-confirmation', (key) => {
                if( key == this.key ) {
                    this.$parent.destroy(this.itemId);
                }
            });
        },
        data() {
            return {
                key: Math.random().toString(36).substr(2),
                modalTemplate: `
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="gridSystemModalLabel">Removal Confirmations</h4>
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
            itemId : {
                default: null
            }
        }
    }
</script>