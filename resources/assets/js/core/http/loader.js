import axios from './axios'
import store from './../store'

/**
 * This file is used to load data before proceeding along the route.
 *
 * @example
 *  // Your component...
 *  export default {
 *      beforeRouteEnter (to, from, next) {
 *          loader.beforeRouteEnter(`/example`, to, from, next);
 *      },
 *      beforeRouteUpdate (to, from, next) {
 *          loader.beforeRouteUpdate(`/example`, to, from, next, this);
 *      },
 *      methods: {
 *          setData(response) {
 *              //
 *          }
 *      }
 *  }
 */
export default {
    beforeRouteEnter(url, to, from, next) {
        axios.get(url)
            .then((response) => {
                // If is error.
                if (typeof response.response !== 'undefined') {
                    if (response.status === 500) {
                        store.commit('requestError');
                    }

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
                if (err.response.status === 500) {
                    store.commit('requestError');
                }
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
                if (err.response.status === 500) {
                    store.commit('requestError');
                }
            });
    }
}
