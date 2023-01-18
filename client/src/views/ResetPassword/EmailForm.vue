<script setup>
import { ref } from "vue";
import { resetPasswordMail } from "@/api/account";
const email = ref("");

const onSubmit = async () => {
    try {
        const response = await resetPasswordMail(email.value);

        if (response.status === 200) {
            console.log("Email envoyé");
        } else {
            console.log("Erreur");
        }
    } catch (error) {
        console.log(error);
    }
};
</script>

<template>
    <div class="flex flex-col items-center gap-6">
        <h3 class="text-3xl">Réinitialiser mon mot de passe</h3>
        <form
            @submit.prevent="onSubmit"
            class="max-w-sm w-4/5 p-6 bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700"
        >
            <div class="mb-6">
                <label
                    for="email"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Renseignez votre e-mail :</label
                >
                <input
                    type="email"
                    id="email"
                    v-model="email"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
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
