import store from 'belt/core/js/permissions/store';

export default {
    data() {
        return {
            gate_entity_type: 'users',
            gate_entity_id: null,
        }
    },
    created() {
        this.gate_entity_id = this.gate_entity_id ? this.gate_entity_id : _.get(window, 'larabelt.auth.id');
        if (this.gateStoreKey && !this.$store.state[this.gateStoreKey]) {
            this.$store.registerModule(this.gateStoreKey, store);
            this.$store.dispatch(this.gateStoreKey + '/construct', {
                entityType: this.gate_entity_type,
                entityID: this.gate_entity_id,
            });
            this.$store.dispatch(this.gateStoreKey + '/load');
        }
    },
    computed: {
        gateAbilities() {
            return this.$store.getters[this.gateStoreKey + '/data'];
        },
        gateStoreKey() {
            if (this.gate_entity_type && this.gate_entity_id) {
                return 'gate' + this.gate_entity_type + this.gate_entity_id;
            }
        },
        gateIsSuper() {
            return _.find(this.gateAbilities, {
                entity_type: '*',
                name: '*',
            });
        },
    },
    methods: {
        can(name, entity_type) {
            if (this.gateIsSuper) {
                return true;
            }

            if (_.find(this.gateAbilities, {
                    entity_type: entity_type,
                    name: '*',
                })) {
                return true;
            }

            if (_.find(this.gateAbilities, {
                    entity_type: '*',
                    name: name,
                })) {
                return true;
            }

            if (_.find(this.gateAbilities, {
                    entity_type: entity_type,
                    name: name,
                })) {
                return true;
            }

            return false;
        },
    }
};