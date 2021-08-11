<template>
<hr>
    <h1 class="display-5 text-center">Tarefas Finalizadas</h1>
    <div class="card" >
        <div class="card-body" v-for="trf in tarefasFinalizadas" :key="trf">
            <div class="row">
                <div class="col">
                    <h3 class="text-center">{{ trf.tarefa }}</h3>
                    <h5>{{ trf.nome }}</h5>
                </div>
                <div class="col">
                    <p>Finalizado em: {{ trf.dataTrf }}</p>

                    <div class="row">
                        <div class="col d-grid gap-2">
                            <button
                                class="btn btn-danger btn-lg text-center"
                                @click="handleExcluir(trf.id)"
                            >
                                excluir
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
    props: ["tarefasFinalizadas"],
    emits: ["refreshTarefasFinalizadas", 'TarefaMensagem'],
    setup(props, context) {
        const handleExcluir = (id) => {
            axios.delete("api/tarefas/" + id).then((resp) => {
                console.log(resp);
                context.emit("TarefaMensagem", resp.data.message);
                context.emit("refreshTarefasFinalizadas");
            });
        };

        return {
            handleExcluir,
        };
    },
};
</script>

<style>
.card{
    border: none;
}
</style>
