// components
import roles from '../roles/ctlr/index';

// templates
import heading_html from 'belt/core/js/templates/heading.html';
import tabs_html from '../templates/tabs.html';
import edit_html from '../templates/edit.html';

export default {
    data() {
        return {
            morphable_type: 'users',
            morphable_id: this.$route.params.id,
        }
    },
    components: {
        heading: {template: heading_html},
        tabs: {template: tabs_html},
        edit: roles,
    },
    mounted() {
        //this.table.index();
    },
    methods: {
        // attach(id) {
        //     this.form.setData({id: id});
        //     this.form.store()
        //         .then(response => {
        //             this.table.index();
        //             this.detached.index();
        //         })
        // }
    },
    template: edit_html
}