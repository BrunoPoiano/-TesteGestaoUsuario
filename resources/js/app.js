import { createApp } from "vue";
import Content from "./Content.vue";
import Router from "./Router/Router.js";
import Vuex from './Store/Index.js'
 
const app = createApp({});
app.component("content", Content).use(Router).use(Vuex).mount("#app");

require("./bootstrap"); 
