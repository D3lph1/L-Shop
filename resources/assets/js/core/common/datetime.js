export default class DateTime {
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
