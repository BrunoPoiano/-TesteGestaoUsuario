<template>
    <div class="row container align-items-center">
        <h4 v-if="mensagem" class="text-center">{{ mensagem }}</h4>
        <div class="col">
            <h4>Atualizar Senha</h4>
        </div>
        <div class="col boxShadow">
            <div class="card card-body">
                <div class="col">
                    <label class="form-label text-left">Nova Senha</label>
                    <input
                        type="password"
                        class="form-control form-control-lg"
                        v-model="password.novaSenha"
                    />
                </div>
                <div class="col">
                    <label class="form-label text-left">Senha Antiga</label>
                    <input
                        type="password"
                        class="form-control form-control-lg"
                        v-model="password.senhaAntiga"
                    />
                </div>

                <div class="col text-right p-2">
                    <button
                        class="btn btn-success"
                        @click="handleUpdateSenha()"
                    >
                        Atualizar Senha
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from "@vue/reactivity";
export default {
    props: ["userPassword"],
    setup(props) {
        const mensagem = ref("");
        const password = ref({ novaSenha: "", senhaAntiga: "" });

        const handleUpdateSenha = (id) => {
            axios
                .put("api/updatePassword" , {
                    novaSenha: password.value.novaSenha,
                    senhaAntiga: password.value.senhaAntiga,
                })
                .then((resp) => {
                    console.log(resp.data);
                    mensagem.value = resp.data.message;
                });
        };

        return {
            handleUpdateSenha,
            mensagem,
            password,
        };
    },
};
</script>

<style scoped>
.boxShadow {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
</style>
