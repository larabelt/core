import storeAdapter from 'belt/core/js/translations/store/adapter';
import group from 'belt/core/js/translations/list/group';
import edit from 'belt/core/js/translations/edit';
import html from 'belt/core/js/translations/list/template.html';

export default {
    mixins: [storeAdapter],
    props: {
        translatable_type: {
            default: function () {
                return this.$parent.entity_type;
            }
        },
        translatable_id: {
            default: function () {
                return this.$parent.entity_id;
            }
        },
    },
    data() {
        return {
            eventBus: new Vue(),
        }
    },
    created() {
        let eventKey = this.translatable_type + ':' + this.translatable_id + ':updating';
        Events.$on(eventKey, () => {
            this.update();
        });
    },
    computed: {
        groups() {
            return _.get(this.translationConfigs, 'groups', []);
        },
        sortedTranslations() {
            //let sorted = [];
            let configs = _.get(this.translationConfigs, 'translations');
            let sorted = {};
            _.forEach(configs, (config, translationKey) => {
                let translation = _.find(this.translations, {key: translationKey});
                if (translation) {
                    let groupKey = _.get(config, 'group') ? _.get(config, 'group') : 'not-a-group-' + translation.id;
                    translation.config = config;
                    _.set(sorted, groupKey + '.' + translationKey, translation);
                }
            });
            return sorted;
        },
    },
    methods: {
        isGroup(key) {
            return !key.includes('not-a-group');
            //return isNaN(parseFloat(key)) && !isFinite(key);
        },
        group(key) {
            return _.get(this.groups, key);
        },
        update() {
            this.eventBus.$emit('update');
            setTimeout(() => {
                this.translationsLoad();
            }, 500);
        },
    },
    components: {
        group,
        edit: edit,
    },
    template: html
}