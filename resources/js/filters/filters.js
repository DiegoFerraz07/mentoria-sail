import moment from 'moment';

export default {
    formatDate(value, mask = 'MM/DD/YYYY hh:mm') {
        if (value) {
            return moment(String(value)).format(mask)
        } else {
            return moment().format(mask)
        }
    }, 

    formatId(value) {
        if (value) {
            return `#${value}`;
        }
    }
}