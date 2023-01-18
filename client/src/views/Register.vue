<script setup>
import { reactive } from "vue";
import { register } from "@/api/auth";

import { onMounted, onUpdated, ref } from "vue";
import { useRouter } from "vue-router";

import { REGISTER_CLIENT, REGISTER_DELIVERER } from "../router/constants";

const props = defineProps({
  source: {
    type: Symbol,
    required: true,
  },
});

const route = useRouter();

const isClient = ref(false);
const isDeliverer = ref(false);

const _inputsRegister = reactive({
  firstname: "adel",
  lastname: "sen",
  email: "adelsen@esgi",
  roles: "",
  plainPassword: "esgi",
  address: "paris",
  birthday_at: new Date().toISOString().slice(0, 10),
});

function refreshRoles() {
  isClient.value = props.source === REGISTER_CLIENT;
  isDeliverer.value = props.source === REGISTER_DELIVERER;

  if (isClient.value) {
    _inputsRegister.roles = ["ROLE_CLIENT"];
  }
  if (isDeliverer.value) {
    _inputsRegister.roles = ["ROLE_DELIVERER"];
  }
}

onMounted(() => refreshRoles());
onUpdated(() => refreshRoles());

function handleRegister() {
  register({
    ..._inputsRegister,
    birthday_at: new Date(_inputsRegister.birthday_at).toISOString(),
  })
    .then(({ data }) => {
      console.log(data);
      route.push({ name: "login" });
    })
    .catch((error) => {
      console.error(error.response.data);
    });
}
</script>

<template>
  <div class="flex-col">
    <div class="block mb-10">
      <h1 class="text-4xl" v-if="isClient">Inscription d'un client</h1>
      <h1 class="text-4xl" v-if="isDeliverer">Inscription d'un livreur</h1>
    </div>

    <div class="block">
      <form @submit.prevent="handleRegister">
        <div class="mb-6">
          <label class="block mb-2 text-sm font-medium text-gray-900"
            >Email</label
          >
          <input
            type="email"
            v-model="_inputsRegister.email"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
            required
          />
        </div>

        <div class="grid md:grid-cols-2 md:gap-6">
          <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900"
              >Prénom</label
            >
            <input
              type="text"
              v-model="_inputsRegister.firstname"
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
              required
            />
          </div>

          <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900"
              >Nom</label
            >
            <input
              type="text"
              v-model="_inputsRegister.lastname"
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
              required
            />
          </div>
        </div>

        <div class="mb-6">
          <label class="block mb-2 text-sm font-medium text-gray-900"
            >Adresse</label
          >
          <input
            type="text"
            v-model="_inputsRegister.address"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
            required
          />
        </div>

        <div class="mb-6">
          <label class="block mb-2 text-sm font-medium text-gray-900"
            >Date de naissance</label
          >
          <input
            type="date"
            v-model="_inputsRegister.birthday_at"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
            required
          />
        </div>

        <div class="mb-6">
          <label class="block mb-2 text-sm font-medium text-gray-900"
            >Mot de passe</label
          >
          <input
            type="password"
            v-model="_inputsRegister.plainPassword"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
            required
          />
        </div>

        <button
          type="submit"
          class="mb-10 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center"
        >
          S'inscrire
        </button>

        <div class="flex justify-center" v-if="isClient">
          <p>Vous êtes livreur ?&nbsp;</p>
          <router-link
            class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
            :to="{ name: 'registerDeliverer' }"
          >
            S'inscrire ici</router-link
          >
        </div>

        <div class="flex justify-center" v-if="isDeliverer">
          <p>Vous êtes client ?&nbsp;</p>
          <router-link
            class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
            :to="{ name: 'registerClient' }"
          >
            S'inscrire ici</router-link
          >
        </div>
      </form>
    </div>
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
  background: linear-gradient(
    to bottom right,
    rgba(240, 147, 251, 1),
    rgba(245, 87, 108, 1)
  );
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
