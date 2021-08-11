import {
    createWebHistory,
    createRouter,
    createWebHashHistory,
} from "vue-router";
//Navegação
import Tarefas from "../Pages/Tarefas/Tarefas.vue";
import UserCrud from "../Pages/User/UserCrud.vue";

//Auth
import Login from "../Auth/Login.vue";
import Signup from "../Auth/Signup.vue";
const routes = [
    //Navegacao
    {
        path: "/Tarefa",
        name: "Tarefas",
        component: Tarefas,
    },
    {
        path: "/UserCrud",
        name: "UserCrud",
        component: UserCrud,
    },

    //Auth
    {
        path: "/",
        name: "Login",
        component: Login,
    },
    {
        path: "/Signup",
        name: "Signup",
        component: Signup,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
