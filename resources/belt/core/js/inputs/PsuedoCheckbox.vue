<template>
    <span>
        <input type="hidden" v-model="form[column]"/>
        <button class="btn btn-xs" :class="buttonClass" @click.prevent="toggle" :style="style">
            <i class="fa" :class="iconClass"></i>
        </button>
        <slot>{{ label }}</slot>
    </span>
</template>
<script>
    import shared from 'belt/core/js/inputs/shared';

    export default {
        mixins: [shared],
        props: {
            marginBottom: {
                default: '0'
            },
        },
        computed: {
            isActive() {
                return this.form[this.column];
            },
            buttonClass() {
                return this.isActive ? 'btn-primary' : 'btn-default';
            },
            iconClass() {
                return this.isActive ? 'fa-check-square-o' : 'fa-square-o';
            },
            style() {
                return 'margin-bottom: ' + this.marginBottom;
            }
        },
        methods: {
            toggle() {
                this.form[this.column] = !this.form[this.column];
                this.$emit('toggle');
            }
        }
    }
</script>