<template>
    <!--NAVBAR-->
    <nav-auth />

    <!--LOGIN FORM-->
    <div class="container pt-5">
        <div class="row justify-content-center">
            <div class="col-md-9 p-3 boxShadow">
                <div class="card">
                    <h3 class="text-center ">Login</h3>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <input
                                type="text"
                                name="email"
                                placeholder="Email"
                                id="email"
                                class="form-control form-control-lg"
                                required
                                v-model="user.email"
                            />
                        </div>

                        <div class="form-group mb-3">
                            <input
                                type="password"
                                name="password"
                                placeholder="Password"
                                id="password"
                                class="form-control form-control-lg"
                                required
                                v-model="user.password"
                            />
                        </div>

                        <div class="container pt-2 pb-2">
                            <router-link class="register m-1" to="/Signup">
                                Não Possui Cadastro?
                            </router-link>
                        </div>

                        <div class="d-grid mx-auto">
                            <button
                                type="submit"
                                class="btn btn-lg btn-success"
                                @click="handleLogin"
                            >
                                Login
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <h3 class="text-center">{{ LoginMensagem }}</h3>
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
        const user = ref({ email: "", password: "" });
        let fd = new FormData();
        const router = useRouter();
        const userStatus = ref();
        const LoginMensagem = ref();
        const handleLogin = () => {
            fd.append("email", user.value.email);
            fd.append("password", user.value.password);
            axios
                .post("api/createSignin", fd)
                .then((resp) => {
                    if (resp.status == 200) {
                        store.commit("userLogin");
                        userStatus.value = store.getters.userStatus;
                        store.commit("updateUserStatusLocalStorage");
                        console.log("userStatos login ", userStatus.value);
                        console.log(resp.data);
                        router.push({ path: "/Tarefa" });
                    } else {
                    }
                })
                .catch((err) => {
                    LoginMensagem.value =
                        "Erro ao fazer Login, Verifique sua senha, email ou atualize a pagina";
                });
        };
        return {
            user,
            handleLogin,
            LoginMensagem,
        };
    },
};
</script>

<style scoped>
.register {
    text-decoration: none;
    cursor: pointer;
    font-size: 1.3rem;
    color: rgb(138, 138, 138);
}
.register:hover {
    color: black;
}

.boxShadow {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
</style>
