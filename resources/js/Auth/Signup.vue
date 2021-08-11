<template>
    <!--NAVBAR-->
    <nav-auth />

    <!--SignUP FORM-->
    <div class="container pt-5">
        <div class="row justify-content-center">
            <div class="col-md-9 p-3 boxShadow">
                <div class="card">
                    <h3 class="text-center">Signup</h3>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <input
                                type="text"
                                name="name"
                                placeholder="Name"
                                id="name"
                                class="form-control form-control-lg"
                                v-model="newUser.name"
                            />
                        </div>

                        <div class="form-group mb-3">
                            <input
                                type="text"
                                name="email"
                                placeholder="Email"
                                id="email_address"
                                class="form-control form-control-lg"
                                v-model="newUser.email"
                            />
                        </div>

                        <div class="form-group mb-3">
                            <input
                                type="password"
                                name="password"
                                placeholder="Password"
                                id="password"
                                :class="[
                                    newUser.password.length < 6
                                        ? 'inputDanger'
                                        : '',
                                    'form-control form-control-lg',
                                ]"
                                v-model="newUser.password"
                            />
                            <span
                                class="text-danger text-center"
                                v-if="newUser.password.length < 6"
                            >
                                Senha Precisa ter no minimo 6 characteres
                            </span>
                        </div>

                        <div class="d-grid mx-auto">
                            <button
                                type="submit"
                                class="btn btn-lg btn-primary btn-block"
                                @click="handleSubmit"
                            >
                                Register
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <h3 class="text-center">{{ signupMensagem }}</h3>
    </div>
</template>

<script>
import { ref } from "@vue/reactivity";
import { useRouter } from "vue-router";
import { onMounted } from "@vue/runtime-core";
import store from "../Store/Index";
import NavAuth from "../components/NavAuth.vue";

export default {
    components: { NavAuth },
    setup() {
        const newUser = ref({ name: "", email: "", password: "" });
        let fd = new FormData();
        const router = useRouter();
        const userStatus = ref();
        const signupMensagem = ref();
        onMounted(() => {
            userStatus.value = store.getters.userStatus;
            console.log("userStatos login ", userStatus.value);
        });

        const handleSubmit = () => {
            fd.append("name", newUser.value.name);
            fd.append("email", newUser.value.email);
            fd.append("password", newUser.value.password);
            axios
                .post("api/customSignup", fd)
                .then((resp) => {
                    if (resp.status == 200) {
                        router.push({ name: "Login" });
                    }
                })
                .catch((err) => {
                    signupMensagem.value =
                        "Erro ao fazer Cadastro, Email pode já estar em uso";
                });
        };
        return {
            newUser,
            handleSubmit,
            signupMensagem,
        };
    },
};
</script>

<style scoped>
.inputDanger {
    border-color: red;
}

.boxShadow {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
</style>
