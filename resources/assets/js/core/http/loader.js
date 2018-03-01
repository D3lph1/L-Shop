import axios from './axios'
import store from './../store'

export default {
    beforeRouteEnter(url, to, from, next) {
        axios.get(url)
            .then((response) => {
                // If is error.
                if (typeof response.response !== 'undefined') {
                    store.commit('requestError');

                    return;
                }

                next(vm => {
                    if (typeof vm.setData === 'undefined') {
                        throw Error('Loader target must be contains method setData(response)');
                    }

                    vm.setData(response)
                });
            })
            .catch((err) => {
                store.commit('requestError');
            });
    },
    beforeRouteUpdate(url, to, from, next, vm) {
        if (typeof vm.setData === 'undefined') {
            throw Error('Loader target must be contains method setData(response)');
        }

        axios.get(url)
            .then((response) => {
                vm.setData(response);

                next();
            })
            .catch((err) => {
                store.commit('requestError');
            });
    }
}
