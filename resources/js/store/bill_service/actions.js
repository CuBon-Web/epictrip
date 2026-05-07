import {HTTP} from '../../core/plugins/http'

export const listServiceBooking = ({commit}, opt) => {
    return new Promise((resolve, reject) => {
        HTTP.post('/api/bill_service/list', opt).then(response => {
            return resolve(response.data);
        }).catch(error => {
            return reject(error);
        })
    });
};

export const detailServiceBooking = ({commit}, id) => {
    return new Promise((resolve, reject) => {
        HTTP.get('/api/bill_service/detail/' + id).then(response => {
            return resolve(response.data);
        }).catch(error => {
            return reject(error);
        })
    });
};

export const deleteServiceBooking = ({commit}, id) => {
    return new Promise((resolve, reject) => {
        HTTP.get('/api/bill_service/delete/' + id).then(response => {
            return resolve(response.data);
        }).catch(error => {
            return reject(error);
        })
    });
};
