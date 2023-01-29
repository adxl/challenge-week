<script setup>
const props = defineProps({
  path: {
    type: Object,
    required: true,
  },
});
</script>

<template>
  <router-link class="text-white" :to="props.path">
    <button
      type="button"
      class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
    >
      <svg
        fill="none"
        stroke="currentColor"
        stroke-width="1.5"
        class="w-5 h-5 inline mr-3"
        viewBox="0 0 24 24"
        xmlns="http://www.w3.org/2000/svg"
        aria-hidden="true"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          d="M19.5 12h-15m0 0l6.75 6.75M4.5 12l6.75-6.75"
        ></path>
      </svg>
      Retour
    </button>
  </router-link>
</template>
