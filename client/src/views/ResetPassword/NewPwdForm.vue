<script setup>
import { ref } from "vue";
import { resetPassword } from "@/api/account";
import { useRouter } from "vue-router";
const pwd = ref("");
const pwdConfirm = ref("");

const route = useRouter();
const token = route.currentRoute.value.params.token;

const onSubmit = async () => {
  if (pwd.value !== pwdConfirm.value) {
    return console.error("Les mots de passe ne correspondent pas");
  }

  resetPassword(token, pwd.value)
    .then(() => {
      route.push({ name: "login" });
    })
    .catch((error) => {
      console.log(error);
    });
};
</script>

<template>
  <div
    class="flex flex-col items-center gap-6 border rounded-lg shadow-md bg-gray-800 border-gray-700 p-5"
  >
    <h3 class="text-3xl text-white">Réinitialiser mon mot de passe</h3>
    <form @submit.prevent="onSubmit" class="w-full">
      <div class="mb-6">
        <label for="pwd" class="block mb-2 text-sm font-medium text-white"
          >Nouveau mot de passe</label
        >
        <input
          type="password"
          id="pwd"
          v-model="pwd"
          class="border 0 text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500"
          placeholder="********"
          required
        />
      </div>
      <div class="mb-6">
        <label for="pwdConfirm" class="block mb-2 text-sm font-medium text-white"
          >Confirmer le nouveau mot de passe</label
        >
        <input
          type="password"
          id="pwdConfirm"
          v-model="pwdConfirm"
          class="border text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500"
          placeholder="********"
          required
        />
      </div>
      <div class="flex justify-end">
        <button
          type="submit"
          class="block px-4 py-2 text-sm font-medium text-white uppercase transition-colors duration-200 transform bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600"
        >
          Envoyer
        </button>
      </div>
    </form>
  </div>
</template>

<style scoped></style>
