/**
 * Responsible for working with shopping cart
 *
 * @param serverId
 * @constructor
 */
function Cart(serverId) {
    /**
     * Bag of items
     *
     * @type {null|object}
     */
    this.bag = null;

    /**
     * Name of cookie
     *
     * @type {string}
     */
    this.cookie = 'cart';

    /**
     * Id of current server
     */
    this.server = serverId;

    /**
     * @type {Cart}
     */
    var self = this;

    /**
     * Put item in cart
     *
     * @param item
     * @param value
     */
    this.put = function (item, value) {
        get();

        self.bag[self.server][item] = value;
        this.store();
    };

    /**
     * Check of exists item
     *
     * @param item
     * @returns {boolean}
     */
    this.has = function (item) {
        get();
        return !!self.bag[self.server][item];
    };

    /**
     * Get item from cart
     *
     * @param item
     * @returns {*}
     */
    this.get = function (item) {
        get();

        if (self.has(item)) {
            return self.bag[self.server][item];
        }

        return undefined;
    };

    /**
     * Get all items in cart for current server
     *
     * @returns {*}
     */
    this.list = function () {
        return self.bag[self.server];
    };

    /**
     * Storage cart in cookie
     */
    this.store = function () {
        setCookie(self.cookie, JSON.stringify(self.bag), {expires: 10000000});
    };

    /**
     * Remove item from cart
     *
     * @param item {int|string}
     */
    this.remove = function (item) {
        delete self.bag[self.server][item];
        self.store();
    };

    /**
     * Get data from cookie
     */
    function get() {
        var cookie = getFromCookie();

        if (cookie) {
            self.bag = JSON.parse(cookie);
        }else {
            create();
        }
    }

    /**
     * Create cookie with cart section for current server
     */
    function create() {
        self.bag = new Object(null);
        self.bag[self.server] = new Object(null);
        setCookie(self.cookie, JSON.stringify(self.bag), {expires: 10000000});
    }

    /**
     * Get raw - data from cookie
     *
     * @returns {*}
     */
    function getFromCookie() {
        return getCookie(self.cookie);
    }
}
