import Vue from 'vue'

import Notifications from './templates/common/Notifications.vue'
import Preloader from './templates/common/preloaders/LinearPreloader.vue'
import RequestError from './templates/common/RequestError.vue'
import Enchanted from './templates/common/Enchanted.vue'
import Hidden from './templates/common/Hidden.vue'
import ShopGrid from './templates/layout/shop/Grid.vue'

import Upload from './components/Uploader.vue'

/**
 * Register global application components.
 */

Vue.component('notifications', Notifications);
Vue.component('preloader', Preloader);
Vue.component('request-error', RequestError);
Vue.component('v-uploader', Upload);
Vue.component('v-enchanted', Enchanted);
Vue.component('v-hidden', Hidden);
Vue.component('shop-grid', ShopGrid);
