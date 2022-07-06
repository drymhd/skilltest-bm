import VueRouter from 'vue-router';


const routes = [{
        name: 'home',
        path: '/',
        component: () =>
            import ( /* webpackChunkName: "main" */ './pages/home/Index.vue'),
        meta: {
            title: 'home'
        }
    },

];

const router = new VueRouter({
    history: true,
    mode: 'history',
    routes: routes,
});

router.beforeEach((to, from, next) => {
    document.title = to.meta.title;
    next()
});




export default router;