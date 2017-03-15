import Cookies from 'belt/core/js/helpers/cookies';

export default {
    props: {
        id: {},
    },
    data() {
        return {
            result: 'bar',
        }
    },
    methods: {
        dismiss() {
            document.getElementById('alert-' + this.id).style.display = 'none';

            let ids = (new Cookies()).get('alerts').split(',');
            ids.push(this.id.toString());
            ids = _.compact(_.uniq(ids));
            ids = ids.join(',');

            document.cookie = "alerts=" + ids;
        },
    },
    template: `<div><span @click="dismiss"><slot><i class="fa fa-times"></i></slot></span></div>`
}