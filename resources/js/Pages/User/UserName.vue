<template>
    <div class="row container align-items-center ">
        <h4 v-if="mensagem" class="text-center">{{ mensagem }}</h4>
        <div class="col">
            <h4>Atualizar Nome</h4>
        </div>
        <div class="col boxShadow">
            <div class="card card-body ">
                <div class="col">
                    <label class="form-label text-left">Nome</label>
                    <input
                        type="text"
                        class="form-control form-control-lg"
                        v-model="userName.name"
                    />
                </div>

                <div class="col text-right p-2">
                    <button
                        class="btn btn-success"
                        @click="handleUpdateName()"
                    >
                        Atualizar Nome
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from "@vue/reactivity";
export default {
    props: ["userName"],
    setup(props) {
        const mensagem = ref("");

        const handleUpdateName = () => {
            axios
                .put("api/updateName/" , {
                    name: props.userName.name,
                })
                .then((resp) => {
                    console.log(resp.data);
                    mensagem.value = resp.data.message;
                });
        };

        return {
            handleUpdateName,
            mensagem,
        };
    },
};
</script>

<style scoped>
.boxShadow {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
</style>
