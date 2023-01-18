<script setup>
import { reactive } from "vue";
import { register } from "@/api/auth";

import { onMounted, watch, onUpdated, ref } from "vue";

import { REGISTER_CLIENT, REGISTER_DELIVERER } from "../router/constants";

const props = defineProps({
  source: {
    type: Symbol,
    required: true,
  },
});

const isClient = props.source === REGISTER_CLIENT;
const isDeliverer = props.source === REGISTER_DELIVERER;

const _inputsRegister = reactive({
  firstname: "",
  lastname: "",
  email: "",
  roles: "",
  password: "",
});

function refreshRoles() {
  console.log({ isClient, isDeliverer });
  if (isClient) {
    _inputsRegister.roles = "ROLE_CLIENT";
  }
  if (isDeliverer) {
    _inputsRegister.roles = "ROLE_DELIVERER";
  }
}

onMounted(() => refreshRoles());
onUpdated(() => {
  refreshRoles();
});

function handleRegister() {
  console.log({ ..._inputsRegister });
  register({ ..._inputsRegister })
    .then(({ data }) => {
      console.log(data);
    })
    .catch((error) => {
      console.log(error);
    });
}
</script>

<template>
  <div class="flex-col">
    <div class="block mb-1">
      <h1 class="text-4xl" v-if="isClient">Inscription d'un client</h1>
      <h1 v-if="isDeliverer">Inscription d'un livreur</h1>
    </div>

    <div class="block">
      <form>
        <div class="mb-6">
          <label class="block mb-2 text-sm font-medium text-gray-900"
            >Nom</label
          >
          <input
            type="text"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
            required
          />
        </div>
        <div class="mb-6">
          <label class="block mb-2 text-sm font-medium text-gray-900"
            >Prénom</label
          >
          <input
            type="text"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
            required
          />
        </div>
        <div class="mb-6">
          <label class="block mb-2 text-sm font-medium text-gray-900"
            >Your password</label
          >
          <input
            type="password"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
            required
          />
        </div>

        <router-link v-if="!isClient" :to="{ name: 'registerClient' }">
          Vous êtes client ?</router-link
        >
        <router-link v-if="!isDeliverer" :to="{ name: 'registerDeliverer' }">
          Vous êtes livreur ?</router-link
        >

        <button
          type="submit"
          class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center"
        >
          S'inscrire
        </button>
      </form>
    </div>

    <section class="vh-100 gradient-custom">
      <div class="container py-5 h-100">
        <div class="row justify-content-center align-items-center h-100">
          <div class="col-12 col-lg-9 col-xl-7">
            <div
              class="card shadow-2-strong card-registration"
              style="border-radius: 15px"
            >
              <div class="card-body p-4 p-md-5">
                <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Inscription</h3>
                <form>
                  <div class="row">
                    <div class="col-md-6 mb-4">
                      <div class="form-outline">
                        <input
                          type="email"
                          class="form-control form-control-lg"
                          id="email"
                          v-model="_inputsRegister.email"
                          required
                        />
                        <label class="form-label" for="email">Email</label>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6 mb-4 pb-2">
                      <div class="form-outline">
                        <input
                          type="password"
                          id="password"
                          class="form-control form-control-lg"
                          v-model="_inputsRegister.password"
                          required
                        />
                        <label class="form-label" for="password"
                          >Mot de passe</label
                        >
                      </div>
                    </div>
                    <div class="col-md-6 mb-4 pb-2">
                      <div class="form-outline">
                        <input
                          type="password"
                          id="passwordConfirmation"
                          class="form-control form-control-lg"
                        />
                        <label class="form-label" for="passwordConfirmation"
                          >Confirmation de mot de passe</label
                        >
                      </div>
                    </div>
                  </div>

                  <div class="mt-4 pt-2">
                    <input
                      class="btn btn-primary btn-lg"
                      type="submit"
                      value="S'inscrire"
                      @click.prevent="handleRegister"
                    />
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
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
