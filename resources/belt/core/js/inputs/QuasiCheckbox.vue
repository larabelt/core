<template>
    <span>
        <input type="hidden" v-model="form[column]"/>
        <button class="btn btn-xs" :class="buttonClass" @click.prevent="toggle">
            <i class="fa" :class="iconClass"></i>
        </button>
    </span>
</template>
<script>
    import shared from 'belt/core/js/inputs/shared';

    export default {
        mixins: [shared],
        computed: {
            isActive() {
                return this.form[this.column];
            },
            buttonClass() {
                return this.isActive ? 'btn-primary' : 'btn-default';
            },
            iconClass() {
                return this.isActive ? 'fa-check-square-o' : 'fa-square-o';
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