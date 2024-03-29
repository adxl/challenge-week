<script setup>
import { reactive, inject } from "vue";
import { login } from "@/api/auth";
import { useRouter } from "vue-router";
import { initDB } from "../idbHelper";
import { USER_STATUS } from "@/router/constants";

const route = useRouter();

const refreshUser = inject("app_refresh");

const _inputsLogin = reactive({
  email: "",
  password: "",
});

function handleLogin() {
  login({ ..._inputsLogin })
    .then(async ({ data }) => {
      sessionStorage.setItem("cw-app-token", JSON.stringify(data.token));
      initDB();
      const user = await refreshUser();
      if (user.isAdmin) {
        route.push({ name: "admin-dashboard" });
      } else if (user.isDeliverer) {
        if (user.status === USER_STATUS.BANNED) {
          sessionStorage.removeItem("cw-app-token");
          window.location.href = "/login";
        } else route.push({ name: "orders" });
      } else {
        console.log(user);
        route.push({ name: "store" });
      }
    })
    .catch((error) => {
      console.log(error);
    });
}
</script>

<template>
  <div class="block max-w-sm p-6 border rounded-lg shadow bg-gray-800 border-gray-700">
    <form @submit.prevent="handleLogin">
      <div class="mb-6">
        <div class="mb-6">
          <label class="block mb-2 text-sm font-medium text-white">Email</label>
          <input
            type="email"
            v-model="_inputsLogin.email"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
            required
            data-cy="login-email-input"
          />
        </div>
        <div>
          <label class="block mb-2 text-sm font-medium text-white">Mot de passe</label>
          <input
            type="password"
            v-model="_inputsLogin.password"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
            required
            data-cy="login-password-input"
          />
        </div>
        <div class="flex justify-end">
          <router-link
            class="font-medium text-blue-500 hover:underline"
            :to="{ name: 'Reset Password' }"
          >
            Mot de passe oublié</router-link
          >
        </div>
      </div>

      <button
        type="submit"
        class="mb-10 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center"
        data-cy="login-submit-button"
      >
        Se connecter
      </button>

      <div class="flex justify-center">
        <p class="text-white">Vous n'avez pas de compte ?&nbsp;</p>
        <router-link
          class="font-medium text-blue-500 hover:underline"
          :to="{ name: 'registerClient' }"
        >
          S'inscrire ici</router-link
        >
      </div>
    </form>
  </div>
</template>

<style scoped>
.gradient-custom {
  /* fallback for old browsers */
  background: #f093fb;

  /* Chrome 10-25, Safari 5.1-6 */
  background: -webkit-linear-gradient(
    to bottom right,
    rgba(240, 147, 251, 1),
    rgba(245, 87, 108, 1)
  );

  /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
  background: linear-gradient(to bottom right, rgba(240, 147, 251, 1), rgba(245, 87, 108, 1));
}

.card-registration .select-input.form-control[readonly]:not([disabled]) {
  font-size: 1rem;
  line-height: 2.15;
  padding-left: 0.75em;
  padding-right: 0.75em;
}
.card-registration .select-arrow {
  top: 13px;
}
</style>
