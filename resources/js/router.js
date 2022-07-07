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
    {
        name: 'keranjang',
        path: '/keranjang',
        component: () =>
            import ( /* webpackChunkName: "main" */ './pages/keranjang/Index.vue'),
        meta: {
            title: 'keranjang'
        }
    },
    {
        name: 'transaksi',
        path: '/transaksi',
        component: () =>
            import ( /* webpackChunkName: "main" */ './pages/transaksi/Index.vue'),
        meta: {
            title: 'transaksi'
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