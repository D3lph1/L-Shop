export default class Rnd {
    /**
     * Generate a random string with specified length.
     *
     * @param length
     * @returns {string}
     */
    static Str(length) {
        let str = '';
        const possible = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

        for (let i = 0; i < length; i++) {
            str += possible.charAt(Math.floor(Math.random() * possible.length));
        }

        return str;
    }
}
