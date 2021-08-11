<template>
    <h1 class="display-5 text-center">Tarefas</h1>
    <div  v-if="tarefas.length">
        <div class=" card card-body " v-for="trf in tarefas" :key="trf">
            <div class="row">
                <div class="col">
                    <h3 class="text-center">{{ trf.tarefa }}</h3>

                    <h5>{{ trf.nome }}</h5>
                </div>
                <div class="col">
                    <p>Criado em: {{ trf.dataTrf }}</p>
                    <div class="row">
                        <div class="col d-grid gap-2">
                            <button
                                class="btn btn-warning btn-lg text-center"
                                @click="handleEditar(trf)"
                            >
                                Editar
                            </button>
                        </div>
                        <div class="col d-grid gap-2">
                            <button
                                class="btn btn-success btn-lg"
                                @click="handleFinalizado(trf.id)"
                            >
                                Finalizado
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["tarefas"],
    emits: ["refreshTarefas", "editarTarefa", 'TarefaMensagem'],
    setup(props, context) {
        const handleFinalizado = (id) => {
            axios.get("api/tarefas/" + id + "/edit").then((resp) => {
                console.log(resp.data);
                context.emit("refreshTarefas");
                context.emit("TarefaMensagem", resp.data.message);
            });
        };

        const handleEditar = (tarefa) => {
            context.emit("editarTarefa", tarefa);
        };

        return {
            handleFinalizado,
            handleEditar,
        };
    },
};
</script>

<style>
</style>
