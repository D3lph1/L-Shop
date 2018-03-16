import Vue from "vue";

const _ = require('lodash');

/**
 * Produces the translation of content for a given key. The translation dictionary
 * is stored in window.i18n, which is obtained from the connected js file at the
 * address api/js/app.min.js (laravel route: 'frontend.lang.js').
 *
 * @param {String} key. Translation key.
 * @param {Object} [args]. Arguments to replace in a string. There is a substitution: {argName: argValue}.
 * @return {String} Translated string. Or key in case of failure.
 *
 * @example
 *  // Key 'example1' => 'Minecraft'
 *  $t('example1'); // Minecraft
 *
 *  // key 'example2' => 'Hello, :name!'
 *  $t('example2', {name: 'World'}); // Hello, World
 */
window.$t = (key, args) => {
    let value = _.get(window.i18n, key);

    if (typeof value === 'undefined') {
        console.warn(`Localization key '${key}' not found.`);

        return key;
    }

    _.eachRight(args, (paramVal, paramKey) => {
        value = _.replace(value, `:${paramKey}`, paramVal);
    });
    return value;
};

Vue.prototype.$t = window.$t;
