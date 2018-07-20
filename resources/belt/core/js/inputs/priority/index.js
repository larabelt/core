import html from 'belt/core/js/inputs/priority/template.html';

export default {
    props: {
        form: {
            default: function () {
                return this.$parent.form;
            }
        },
        options: {
            default: function () {
                return [
                    0,
                    1,
                    2,
                    3,
                    4,
                    5,
                    6,
                    7,
                    8,
                    9,
                    10,
                ]
            }
        }
    },
    template: html
}