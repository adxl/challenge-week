<script setup>
import { ref } from "vue";
import { resetPasswordMail } from "@/api/account";
const email = ref("");

const onSubmit = () => {
  resetPasswordMail(email.value)
    .then(() => {
      console.log("Email envoyé");
      email.value = "";
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
        <label for="email" class="block mb-2 text-sm font-medium text-white"
          >Renseignez votre e-mail :</label
        >
        <input
          type="email"
          id="email"
          v-model="email"
          class="border text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500"
          placeholder="john.doe@example.com"
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
