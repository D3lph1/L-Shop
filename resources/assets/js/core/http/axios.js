import Axios from 'axios'

/**
 * Configuring axios.
 */

// This header will be added to each query produced by axios.
Axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

export default Axios;
