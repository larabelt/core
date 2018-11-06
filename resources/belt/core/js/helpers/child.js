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

export function propForm() {
    return {
        form: {
            default: function () {
                return this.$parent.form;
            }
        }
    }
}

export default {propEntityID, propEntityType, propForm}