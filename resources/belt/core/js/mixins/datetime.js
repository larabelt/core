import moment from 'moment';

export default {
    methods: {
        datetime(str, pattern) {
            let datetime = moment(str);
            return datetime.format(pattern);
        },
    }
};