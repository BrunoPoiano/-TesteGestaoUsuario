import { createStore } from "vuex";

function userStatus(status) {
    localStorage.setItem("userAuthentication", JSON.stringify(status));
}

const store = createStore({
    state: {
        userAuthentication: false,
    },
    getters: {
        userStatus: (state) => {
            return state.userAuthentication;
        },
    },
    mutations: {
        userLogin(state) {
            userStatus(true);
        },
        userLogout(state) {
            userStatus(false);
        },
        updateUserStatusLocalStorage(state) {
            const user = localStorage.getItem("userAuthentication");
            if (user) {
                state.userAuthentication = JSON.parse(user);
            }
        },
    },
    actions: {},
    modules: {},
});

export default store;
