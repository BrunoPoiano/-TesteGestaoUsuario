<template>
    <div class="card card-body">
        <div class="col">
            <h1 class="display-5 text-center">Criar Novas Tarefas</h1>
        </div>
        <div class="col m-1">
            <input
                v-model="tarefa.tarefa"
                type="text"
                placeholder="Tarefa"
                :class="[
                    tarefa.tarefa.length == 0 ? 'inputDanger' : '',
                    'form-control form-control-lg',
                ]"
            />
        </div>
        <span class="text-center" v-if="tarefa.tarefa.length == 0">
            Tarefa Não pode ser vazia
        </span>

        <div class="col m-1">
            <select
                :class="[
                    tarefa.prioridade.length == 0 ? 'inputDanger' : '',
                    'form-select form-select-lg',
                ]"
                aria-label="Default select example"
                v-model="tarefa.prioridade"
            >

                <option v-for="pri in prioridades" :key="pri" :value="pri.id">
                    {{ pri.nome }}
                </option>
            </select>
        </div>
        <span class="text-center" v-if="tarefa.prioridade.length == 0">
            Escolha uma Prioridade
        </span>
        <div class="row pt-2">
            <div class="col d-grid gap-2">
                <button
                    class="btn btn-success btn-lg text-center"
                    @click="handleCriarTarefa"
                >
                    Criar
                </button>
            </div>
            <div class="col d-grid gap-2">
                <button class="btn btn-danger btn-lg">Cancelar</button>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from "@vue/reactivity";
import { onMounted } from "@vue/runtime-core";
export default {
    emits: ["refreshTarefas", "TarefaMensagem"],
    setup(props, context) {
        const tarefa = ref({ tarefa: "", prioridade: "" });
        const fdTarefa = new FormData();
        const prioridades = ref([]);
        onMounted(() => {
            getPrioridades();
        });

        const handleCriarTarefa = () => {
            fdTarefa.append("tarefa", tarefa.value.tarefa);
            fdTarefa.append("prioridade", tarefa.value.prioridade);
            axios.post("api/tarefas", fdTarefa).then((resp) => {
                console.log(resp.data);
                tarefa.value.tarefa = "";
                tarefa.value.prioridade = "";
                context.emit("refreshTarefas");
                context.emit("TarefaMensagem", resp.data.message);
            });
        };

        const getPrioridades = () => {
            axios.get("api/prioridades").then((resp) => {
                prioridades.value = resp.data;
            });
        };
        return {
            tarefa,
            handleCriarTarefa,
            prioridades,
        };
    },
};
</script>

<style>
.inputDanger {
    border-color: red;
}
</style>
