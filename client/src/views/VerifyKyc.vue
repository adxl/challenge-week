<script setup>
import { onMounted } from "vue";

onMounted(async () => {});
</script>

<template>
  <div class="max-w-sm p-6 border rounded-lg shadow-md bg-gray-800 border-gray-700">
    <svg
      fill="none"
      stroke="currentColor"
      stroke-width="1.5"
      viewBox="0 0 24 24"
      xmlns="http://www.w3.org/2000/svg"
      aria-hidden="true"
      class="w-12 h-12 mx-auto text-green-500"
    >
      <path
        stroke-linecap="round"
        stroke-linejoin="round"
        d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5"
      ></path>
    </svg>
    <h2 class="mt-4 text-xl font-semibold text-white">
      Merci de votre inscription ! Votre compte est maintenant activé.
    </h2>
    <a href="/login">
      <button
        class="block w-full px-4 py-2 mt-6 font-medium text-white uppercase transition-colors duration-200 transform bg-green-500 rounded-md hover:bg-green-600 focus:outline-none focus:bg-green-600"
      >
        Se connecter
      </button>
    </a>
  </div>
</template>

<style scoped></style>
