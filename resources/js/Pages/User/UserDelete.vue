<template>
    <div class="row container align-items-center">
        <h4 v-if="mensagem" class="text-center">{{ mensagem }}</h4>

        <div class="col">
            <h4 class="text-danger">Deletar Perfil</h4>
        </div>
        <div class="col boxShadow">
            <div class="card card-body">
                <button class="btn btn-danger" @click="handleDeletar">
                    Deletar
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from "@vue/reactivity";
import { useRouter } from "vue-router";
import store from "../../Store/Index";
export default {
    setup() {
        let acao;
        const mensagem = ref();
        const router = useRouter();
        const userStatus = ref()
        const handleDeletar = () => {
            if (
                confirm(
                    "Tem certza que deseja excluir seu perfil? Essa ação não podera ser revertida!"
                )
            ) {
                acao = "Sim";
                axios
                    .get("api/destroy")
                    .then((resp) => {
                        if (resp.status == 200) {
                            store.commit("userLogout");
                            userStatus.value = store.getters.userStatus;
                            store.commit("updateUserStatusLocalStorage");
                            console.log("userStatos login ", userStatus.value);
                            console.log(resp.data);
                            router.push({ name: "Login" });
                        }
                    })
                    .catch((err) => {
                        mensagem.value =
                            "Erro Apagar Perfil, tente novamente mais tarde.";
                    });
            } else {
                acao = "Não";
            }
            console.log(acao);
        };
        return { handleDeletar, mensagem };
    },
};
</script>

<style scoped>
.boxShadow {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
</style>
