class Tabs {
    /**
     * Create a new Tabs instance.
     *
     * @param {object} options
     */
    constructor(options = {}) {
        this.router = options.router;
        this.default = options.default;
        this.toggleable = options.toggleable;
        this.tab = this.default;

        if (this.router && this.router.currentRoute) {
            if (this.router.currentRoute.hash) {
                this.tab = this.router.currentRoute.hash.substring(1);
            }
        }
    }

    set(key) {

        if (this.tab != key) {
            this.tab = key;
            if (this.router) {
                this.router.push({hash: this.tab});
            }
        } else if (this.toggleable) {
            this.tab = '';
        }

    }

    show(key) {
        return this.tab == key;
    }

}

export default Tabs;