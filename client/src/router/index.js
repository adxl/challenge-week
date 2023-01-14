import { createWebHistory, createRouter } from "vue-router";
import Register from "@/views/Register.vue";
import Login from "@/views/Login.vue";
import HelloWorld from "@/components/HelloWorld.vue";

const routes = [
  {
    name: "register",
    path: "/register",
    component: Register,
  },
  {
    name: "login",
    path: "/login",
    component: Login,
  },
  {
    name: "home",
    path: "/",
    component: HelloWorld,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
