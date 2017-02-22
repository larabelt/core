export default {
    methods: {
        drag(e) {
            this.dragged = e.target.getAttribute('data-index');
        },
        drop(e) {
            this.dropped = e.target.getAttribute('data-index');

            if (!this.dragged || !this.dropped || this.dragged == this.dropped) {
                return false;
            }

            let type = this.dragged < this.dropped ? 'after' : 'before';

            this.move(type, this.dragged, this.dropped);

            this.table.index();
        },
        move(type, index, target_index) {
            return new Promise((resolve, reject) => {
                let item;
                let target;
                let items = this.table.items;

                if (items[index] != undefined) {
                    item = items[index];
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

                if (items[target_index] != undefined) {
                    target = items[target_index];
                } else {
                    return false;
                }

                this.form.setData({
                    id: item.id,
                    move: type,
                    position_entity_id: target.id
                });

                this.form.submit()
                    .then(response => {
                        this.table.index();
                        resolve(response.data);
                    })
                    .catch(error => {
                        reject(error.response.data);
                    });
            });
        }
    }
};