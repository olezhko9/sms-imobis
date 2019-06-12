import axios from 'axios'

const baseURL = 'http://176.119.156.135/api/sms.php';

export default {
    fetchAllSms () {
        return axios.get(baseURL)
    },
    saveSms (params) {
        return axios.post(baseURL, params);
    },
}
