/**
 * Utility class for working with date and time.
 */
export default class DateTime {
    /**
     * localizes the accepted date and presents it in a humanized format.
     *
     * @param {String|Date} date. Date object or date in a string representation.
     * @return {String}
     */
    static localize(date) {
        if (typeof date === 'string') {
            date = new Date(date);
        }

        return $t(`datetime.humanized.${date.getMonth() + 1}`, {
            day: date.getDate(),
            year: date.getFullYear(),
            // Time with leading zero.
            time:
                (date.getHours() < 10 ? '0' : '') + date.getHours() + ':' +
                (date.getMinutes() < 10 ? '0' : '') + date.getMinutes() + ':' +
                (date.getSeconds() < 10 ? '0' : '') + date.getSeconds()
        })
    }
}
