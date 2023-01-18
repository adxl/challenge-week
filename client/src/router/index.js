import { createWebHistory, createRouter } from "vue-router";
import Register from "@/views/Register.vue";
import Login from "@/views/Login.vue";
import HelloWorld from "@/components/HelloWorld.vue";
import NotFound from "@/views/NotFound.vue";
import VerifyToken from "@/views/VerifyToken.vue";
import NewPasswordForm from "@/views/ResetPassword/NewPwdForm.vue";
import EmailForm from "@/views/ResetPassword/EmailForm.vue";
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
    path: "/users/verify/:token",
    name: "Verify Token",
    component: VerifyToken,
  },
  {
    path: "/reset-password/:token",
    name: "New Password Form",
    component: NewPasswordForm,
  },
  {
    path: "/reset-password",
    name: "Reset Password",
    component: EmailForm,
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