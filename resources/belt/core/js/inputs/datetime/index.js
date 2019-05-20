import moment from 'moment';
import html from 'belt/core/js/inputs/datetime/template.html';

export default {

    props: {
        table: {default: null},
        form: {default: null},
        column: {default: ''},
        time: {default: false},
        default_date: {default: '+1,days'},
        default_time: {default: '08:00:00'},
    },
    data() {
        return {
            column_date: '',
            column_time: '',
        };
    },
    computed: {
        date() {
            if (this.column_date) {
                let date = moment(this.column_date);
                return date.format("YYYY-MM-DD");
            }

            return null;
        },
        datetime() {
            if (this.column_date) {
                let column_time = this.time && this.column_time ? this.column_time : '00:00:00';
                let datetime = moment(this.column_date + ' ' + column_time);
                return datetime.format("YYYY-MM-DD HH:mm:00");
            }

            return null;
        },
    },
    created() {

        if (this.form) {

            if (this.form[this.column]) {
                this.setDatetimeFromStr(this.form[this.column]);
            }

            if (this.default_date && !this.form[this.column]) {
                // set default date
                let values = this.default_date.split(',');
                let datetime = moment();
                this.column_date = datetime.add(values[0], values[1]).format("YYYY-MM-DD");

                // set default time
                this.column_time = this.default_time;

                this.form[this.column] = this.datetime;
            }

            // set dynamic form watcher
            this.$watch('form.' + this.column, function (newValue) {
                this.setDatetimeFromStr(newValue);
            });


        }

        if (this.table) {
            this.$watch('table.query.' + this.column, function (newValue) {
                this.setDatetimeFromStr(newValue);
            });
        }

    },
    methods: {
        changeDate() {
            if (this.table) {
                this.table.query[this.column] = this.time ? this.datetime : this.date;
                this.table.index()
                    .then(() => {
                        this.table.pushQueryToRouter();
                    });
            }

            if (this.form) {
                this.form[this.column] = this.datetime;
            }
        },
        changeTime() {
            if (this.form) {
                this.form[this.column] = this.datetime;
            }
        },
        setDatetimeFromStr(str) {
            if (str) {
                let datetime = moment(str);
                this.column_date = datetime.format("YYYY-MM-DD");
                this.column_time = datetime.format("HH:mm");
            } else {
                this.column_date = '';
                this.column_time = '';
            }
        }
    },
    template: html
}