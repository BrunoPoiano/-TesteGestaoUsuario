<template>
    <div v-if="userStatus">
        <!--NAVBAR-->
        <nav-content />
        <div class="container pt-3 text-capitalize text-center">
            <h1>{{ trfMensagem }}</h1>
        </div>
        <!--SignUP FORM-->
        <div class="container pt-3 text-capitalize">
            <div class="row">
                <div class="col-8 p-2">
                    <div class="card card-body boxShadow">
                        <div class="col">
                            <tarefas-card
                                :tarefas="tarefas"
                                @refreshTarefas="getTarefas"
                                @editarTarefa="editarTarefa"
                                @TarefaMensagem="tarefaMensagem"
                            />
                        </div>
                        <div class="col">
                            <tarefas-finalizadas-card
                                v-if="tarefasFinalizadas.length"
                                :tarefasFinalizadas="tarefasFinalizadas"
                                @refreshTarefasFinalizadas="
                                    getTarefasFinalizadas
                                "
                                @TarefaMensagem="tarefaMensagem"
                            />
                        </div>
                    </div>
                </div>
                <div class="col-4 p-2">
                    <div class="card card-body boxShadow">
                        <tarefas-create
                            @refreshTarefas="getTarefas"
                            v-if="switchTarefa"
                            @TarefaMensagem="tarefaMensagem"
                        />
                        <tarefas-editar
                            @refreshTarefas="getTarefas"
                            @cancelarEdit="cancelarEdit"
                            :edtTarefa="edtTarefa"
                            @TarefaMensagem="tarefaMensagem"
                            v-else
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div v-else>
        <nav-auth />
        <div class="container pt3">
            <h2 class="text-center">{{ mensagem }}</h2>
        </div>
    </div>
</template>

<script>
import { onMounted, ref } from "@vue/runtime-core";
import TarefasCreate from "./TarefasCreate.vue";
import TarefasCard from "./TarefasCard.vue";
import TarefasFinalizadasCard from "./TarefasFinalizadasCard.vue";
import TarefasEditar from "./TarefasEditar.vue";
import NavContent from "../../components/NavContent.vue";
import NavAuth from "../../components/NavAuth.vue";
import store from "../../Store/Index";

export default {
    components: {
        TarefasCreate,
        TarefasCard,
        TarefasFinalizadasCard,
        TarefasEditar,
        NavContent,
        NavAuth,
    },
    setup() {
        const switchTarefa = ref(true);
        const tarefas = ref([]);
        const tarefasFinalizadas = ref([]);
        const userStatus = ref();
        const edtTarefa = ref();
        const mensagem = ref();
        const trfMensagem = ref();
        onMounted(() => {
            store.commit("updateUserStatusLocalStorage");
            userStatus.value = store.getters.userStatus;
            console.log("content ", userStatus.value);
            if (userStatus.value == false) {
                mensagem.value = "Pagina Disponivel para usuarios Logados";
            } else {
                getTarefas();
            }
        });
        function handledata(data) {
            const date = new Date(data);
            let dia = date.getDate();
            let mes = date.getMonth();
            let ano = date.getFullYear();
            mes = mes + 1;
            if (dia < 10) {
                dia = "0" + dia;
            }
            if (mes < 10) {
                mes = "0" + mes;
            }
            return (
                dia + "/" + mes + "/" + ano + " | " + date.toLocaleTimeString()
            );
        }

        const getTarefas = () => {
            axios.get("api/userTarefas/").then((resp) => {
                tarefas.value = resp.data;
                tarefas.value.forEach((el) => {
                    el.dataTrf = handledata(el.created_at);
                });
                getTarefasFinalizadas();
            });
        };

        const getTarefasFinalizadas = () => {
            axios.get("api/tarefasFinalizadas/").then((resp) => {
                tarefasFinalizadas.value = resp.data;
                tarefasFinalizadas.value.forEach((el) => {
                    el.dataTrf = handledata(el.updated_at);
                });
            });
        };

        const editarTarefa = (tarefa) => {
            edtTarefa.value = tarefa;
            switchTarefa.value = false;
        };

        const cancelarEdit = () => {
            getTarefas();
            switchTarefa.value = true;
        };

        const tarefaMensagem = (mensagem) => {
            trfMensagem.value = mensagem;
        };

        return {
            getTarefas,
            tarefas,
            tarefasFinalizadas,
            getTarefasFinalizadas,
            editarTarefa,
            edtTarefa,
            cancelarEdit,
            switchTarefa,
            mensagem,
            userStatus,
            tarefaMensagem,
            trfMensagem,
        };
    },
};
</script>

<style scoped>
.boxShadow {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
</style>
