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
            time: date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds()
        })
    }
}
