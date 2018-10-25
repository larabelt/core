<template>
    <div class="clearfix" :style="style">
        <div class="pull-left">
            <div class="btn-group">
                <slot name="left"></slot>
            </div>
        </div>
        <div class="pull-right">
            <div class="btn-group">
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script>
    import shared from 'belt/core/js/button/shared';

    export default {
        mixins: [shared],
        props: {
            marginBottom: {
                type: Number,
                default: 10,
            },
        },
        computed: {
            style() {
                return 'margin-bottom:' + this.marginBottom + 'px';
            }
        }
    }
</script>