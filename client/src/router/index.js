import { createWebHistory, createRouter } from "vue-router";
import Register from "@/views/Register.vue";
import Login from "@/views/Login.vue";
import HelloWorld from "@/components/HelloWorld.vue";
import NotFound from "@/views/NotFound.vue";

import { REGISTER_CLIENT, REGISTER_DELIVERER } from "./constants";

const routes = [
  {
    name: "home",
    path: "/",
    component: HelloWorld,
  },
  {
    name: "registerClient",
    path: "/register/client",
    component: Register,
    props: { source: REGISTER_CLIENT },
  },
  {
    name: "registerDeliverer",
    path: "/register/deliverer",
    component: Register,
    props: { source: REGISTER_DELIVERER },
  },
  {
    name: "login",
    path: "/login",
    component: Login,
  },
  {
    name: "catchAll",
    path: "/:pathMatch(.*)*",
    component: NotFound,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
