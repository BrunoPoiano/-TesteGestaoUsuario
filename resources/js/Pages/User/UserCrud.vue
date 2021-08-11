<template>
    <div v-if="userStatus">
        <!--NAVBAR-->
        <nav-content />

        <!--SignUP FORM-->
        <div class="container pt-3 text-capitalize">
            <h1 class="display-5 text-center">Informaçoes do Usuario</h1>

            <div class="card text-center">
                <div class="card-body m-2 ">
                    <user-name :userName="user" />
                </div>

                <div class="card-body m-2 ">
                    <user-email :userEmail="user" />
                </div>

                <div class="card-body m-2 ">
                    <user-password :userPassword="user" />
                </div>
            </div>
        </div>
    </div>
    <div v-else>
        <nav-auth />
        <div class="container pt-3">
            <h2 class="text-center">{{ mensagem }}</h2>
        </div>
    </div>
</template>

<script>
import { onMounted, ref } from "@vue/runtime-core";
import UserEmail from "./UserEmail.vue";
import UserName from "./UserName.vue";
import UserPassword from "./UserPassword.vue";
import NavContent from "../../components/NavContent.vue";

import store from "../../Store/Index";
import NavAuth from "../../components/NavAuth.vue";
export default {
    components: { UserName, UserEmail, UserPassword, NavContent, NavAuth },
    setup() {
        const user = ref({});
        const userStatus = ref();
        const mensagem = ref();
        onMounted(() => {
            store.commit("updateUserStatusLocalStorage");
            userStatus.value = store.getters.userStatus;
            console.log("content ", userStatus.value);
            if (userStatus.value == false) {
                mensagem.value = "Pagina Disponivel para usuarios Logados";
            }
            axios.get("user").then((resp) => {
                user.value = resp.data;
            });
        });

        return { user, mensagem, userStatus };
    },
};
</script>


<style scoped>
</style>
