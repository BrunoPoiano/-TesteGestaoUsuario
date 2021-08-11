<template>
    <nav class="navbar navbar-dark bg-dark navbar-expand-lg">
        <div class="container-fluid">
            <div class="navbar-nav float-right">
                <router-link class="nav-link" to="/Tarefa">Content</router-link>
                <router-link class="nav-link" to="/UserCrud"
                    >UserCrud</router-link
                >
            </div>

            <div class="navbar-nav float-left">
                <a class="nav-link" style="cursor:pointer" @click="logout">Logout</a>
            </div>
        </div>
    </nav>
</template>

<script>
import { ref } from '@vue/reactivity';

import { useRouter } from "vue-router";
import store from "../Store/Index";
export default {
    
    setup() {
        const router = useRouter();
        const userStatus = ref();

        const logout = () => {
            axios.get("api/logout ").then((resp) => {
                if (resp.status == 200) {
                    store.commit("userLogout");
                    userStatus.value = store.getters.userStatus;
                    store.commit("updateUserStatusLocalStorage");
                    console.log("userStatos Lougout ", userStatus.value);

                    router.push({ name: "Login" });
                }
            });
        };

        return {
            logout,
        };
    },
};
</script>

<style></style>
