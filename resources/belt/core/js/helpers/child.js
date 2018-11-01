export function propEntityID() {
    return {
        entity_id: {
            default: function () {
                return this.$parent.entity_id;
            }
        }
    }
}

export function propEntityType() {
    return {
        entity_type: {
            type: String,
            default: function () {
                return this.$parent.entity_type;
            }
        }
    }
}

export default {propEntityID, propEntityType}