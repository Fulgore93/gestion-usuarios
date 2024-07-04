import { createRouter, createWebHistory } from "vue-router";
import login from "../componentes/auth/login.vue";
import userRegister from "../componentes/user/userRegister.vue";
import userIndex from "../componentes/user/userIndex.vue";
import userShow from "../componentes/user/userShow.vue";
import userCreate from "../componentes/user/userCreate.vue";
import userEdit from "../componentes/user/userEdit.vue";

const routes = [
    {
        path: "/",
        name: "Login",
        component: login,
    },
    {
        path: "/register",
        name: "User register",
        component: userRegister,
    },
    {
        path: "/users",
        name: "User index",
        component: userIndex,
    },
    {
        path: "/users/show/:id",
        name: "User show",
        component: userShow,
        props: true,
    },
    {
        path: "/users/create",
        name: "User create",
        component: userCreate,
    },
    {
        path: "/users/edit/:id",
        name: "User edit",
        component: userEdit,
    },
    {
        path: '/:pathMatch(.*)*',
        name: 'NotFound',
        component: () => import("../pages/404.vue"),
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    const publicPages = ['/', '/register'];
    const authRequired = !publicPages.includes(to.path);
    const user = localStorage.getItem('userEmail');

    if (authRequired && !user) {
        next('/');
    } else {
        next();
    }
});

export default router;