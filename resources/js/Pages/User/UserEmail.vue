<template>
    <div class="row container align-items-center">
        <h4 v-if="mensagem" class="text-center">{{ mensagem }}</h4>
        <div class="col">
            <h4>Atualizar Email</h4>
        </div>
        <div class="col boxShadow">
            <div class="card card-body">
                <div class="col">
                    <label class="form-label text-left">Email</label>
                    <input
                        type="text"
                        class="form-control form-control-lg"
                        v-model="userEmail.email"
                    />
                </div>

                <div class="col text-right p-2">
                    <button
                        class="btn btn-success"
                        @click="handleUpdateEmail()"
                    >
                        Atualizar Email
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from "@vue/reactivity";
export default {
    props: ["userEmail"],
    setup(props) {
        const mensagem = ref("");

        const handleUpdateEmail = () => {
            axios
                .put("api/updateEmail", {
                    email: props.userEmail.email,
                })
                .then((resp) => {
                    console.log(resp.data);
                    mensagem.value = resp.data.message;
                });
        };

        return {
            handleUpdateEmail,
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