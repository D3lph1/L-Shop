import Vue from "vue";

const _ = require('lodash');

window.$t = (string, args) => {
    let value = _.get(window.i18n, string);

    if (typeof value === 'undefined') {
        console.warn(`Localization key '${string}' not found.`);

        return string;
    }

    _.eachRight(args, (paramVal, paramKey) => {
        value = _.replace(value, `:${paramKey}`, paramVal);
    });
    return value;
};

Vue.prototype.$t = window.$t;
