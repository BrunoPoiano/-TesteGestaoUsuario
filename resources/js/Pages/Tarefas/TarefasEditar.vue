<template>
    <div class="card card-body">
        <div class="col">
            <h1 class="display-5 text-center">Editar Tarefa</h1>
        </div>
        <div class="col">
            <label class="form-label text-left">Tarefa</label>
            <input
                v-model="edtTarefa.tarefa"
                type="text"
                class="form-control form-control-lg"
            />
        </div>

        <div class="col">
            <label for="" class="form-label text-left">Prioridade</label>
            <select
                class="form-select form-select-lg"
                aria-label="Default select example"
                v-model="edtTarefa.prioridade"
            >
                <option v-for="pri in prioridades" :key="pri" :value="pri.id">
                    {{ pri.nome }}
                </option>
            </select>
        </div>
        <div class="row pt-2">
            <div class="col d-grid gap-2">
                <button
                    class="btn btn-warning btn-lg text-center"
                    @click="handleEditar"
                >
                    Editar
                </button>
            </div>
            <div class="col d-grid gap-2">
                <button class="btn btn-danger btn-lg" @click="handleCancelar">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from "@vue/reactivity";
import { onMounted } from "@vue/runtime-core";
export default {
    props: ["edtTarefa"],
    emits: ["refreshTarefas", "cancelarEdit",'TarefaMensagem'],
    setup(props, context) {
        const tarefa = ref({ tarefa: "", prioridade: "" });
        const prioridades = ref([]);

        onMounted(() => {
            getPrioridades();
            console.log("props.edtTarefa ", props.edtTarefa);
        });

        const handleEditar = () => {
            axios
                .put("api/tarefas/" + props.edtTarefa.id, {
                    tarefa: props.edtTarefa.tarefa,
                    prioridade: props.edtTarefa.prioridade,
                })
                .then((resp) => {
                    console.log(resp.data);
                    context.emit("refreshTarefas");
                context.emit("TarefaMensagem", resp.data.message);

                    handleCancelar();
                });
        };

        const handleCancelar = () => {
            tarefa.value.tarefa = "";
            tarefa.value.prioridade = "";
            context.emit("cancelarEdit");
        };

        const getPrioridades = () => {
            axios.get("api/prioridades").then((resp) => {
                prioridades.value = resp.data;
            });
        };
        return {
            tarefa,
            prioridades,
            handleEditar,
            handleCancelar,
        };
    },
};
</script>

<style></style>
