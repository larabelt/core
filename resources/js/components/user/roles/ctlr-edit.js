import taggableService from './service';
import taggableIndexTemplate from './templates/index';

export default {
    data() {
        return {
            taggable_type: this.$parent.morphable_type,
            taggable_id: this.$parent.morphable_id,
        }
    },
    components: {
        'taggable-index': {
            mixins: [taggableService],
            template: taggableIndexTemplate,
            data() {
                return {
                    taggable_type: this.$parent.taggable_type,
                    taggable_id: this.$parent.taggable_id,
                }
            },
            mounted() {
                this.paginate();
            },
        },
    },
    template: `
        <div>
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Tags</h3>
                </div>
                <div class="box box-primary">
                    <div class="box-body">
                        <taggable-index></taggable-index>
                    </div>
                </div>
            </div>
        </div>
        `
}