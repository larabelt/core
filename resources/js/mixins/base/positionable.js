export default {
    methods: {
        move(type, index, target_index) {

            let item;
            let target;

            if (this.items[index] != undefined) {
                item = this.items[index];
            } else {
                return false;
            }

            if (target_index == undefined) {
                if (type == 'after') {
                    target_index = index + 1;
                } else {
                    target_index = index - 1;
                }
            }

            if (this.items[target_index] != undefined) {
                target = this.items[target_index];
            } else {
                return false;
            }

            this.item = item;

            this.update({move: type, position_entity_id: target.id});
        }
    }
};