import Vue from 'vue'
import Router from 'vue-router'
import routes from './routes'
import store from './../core/store'

Vue.use(Router);

const router = new Router({
    mode: 'history',
    routes
});

const title = document.title;

router.beforeEach((to, from, next) => {
    //store.commit('startLoading');

    // Sets the title for the current page. The header is obtained from the
    // meta attribute of the route.
    if (typeof to.meta.title !== 'undefined') {
        document.title = `${to.meta.title} | ${title}`;
    } else {
        document.title = title;
    }

    next();
});

export default router;
