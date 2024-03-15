import moment from 'moment';

export default {
    formatDate(value) {
        if (value) {
            return moment(String(value)).format('MM/DD/YYYY hh:mm')
        } else {
            return moment().format('MM/DD/YYYY hh:mm')
        }
    }, 

    formatId(value) {
        if (value) {
            return `#${value}`;
        }
    }
}