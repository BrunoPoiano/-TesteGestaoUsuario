<template>
    <router-view />
</template>
<script>
import { ref } from "@vue/reactivity";
import store from "./Store/Index";
import { onMounted } from "@vue/runtime-core";
export default {
    setup() {
        const userStatus = ref();
        const mensagem = ref();

        onMounted(() => {
            store.commit("updateUserStatusLocalStorage");
            userStatus.value = store.getters.userStatus;
            console.log("content ", userStatus.value);
            if (userStatus.value == false) {
                mensagem.value = 'Pagina Disponivel para usuarios Logados';
            }
        });

        return { userStatus, mensagem };
    },
};
</script>
