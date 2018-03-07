import Vue from 'vue'

import Notifications from './templates/common/Notifications.vue'
import GlobalPreloader from './templates/common/GlobalPreloader.vue'
import RequestError from './templates/common/RequestError.vue'
import Enchanted from './templates/common/Enchanted.vue'

import Upload from './components/Uploader.vue'

// Register application components.

Vue.component('notifications', Notifications);
Vue.component('global-preloader', GlobalPreloader);
Vue.component('request-error', RequestError);
Vue.component('v-uploader', Upload);
Vue.component('v-enchanted', Enchanted);
