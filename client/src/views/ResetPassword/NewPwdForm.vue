<script setup>
import { ref } from "vue";
import { resetPassword } from "@/api/account";
import { useRoute } from "vue-router";
const pwd = ref("");
const pwdConfirm = ref("");

const route = useRoute();
const token = route.params.token;

const onSubmit = async () => {
    if (pwd.value !== pwdConfirm.value) {
        console.log("Les mots de passe ne correspondent pas");
        return;
    }

    resetPassword(token, pwd.value)
        .then((response) => {
            console.log(response);
        })
        .catch((error) => {
            console.log(error);
        });
};
</script>

<template>
    <div class="flex flex-col items-center gap-6">
        <h3 class="text-3xl">Réinitialiser mon mot de passe</h3>
        <form
            @submit.prevent="onSubmit"
            class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700"
        >
            <div class="mb-6">
                <label
                    for="pwd"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Votre mot de passe :</label
                >
                <input
                    type="password"
                    id="pwd"
                    v-model="pwd"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="********"
                    required
                />
            </div>
            <div class="mb-6">
                <label
                    for="pwdConfirm"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Votre mot de passe :</label
                >
                <input
                    type="password"
                    id="pwdConfirm"
                    v-model="pwdConfirm"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
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
