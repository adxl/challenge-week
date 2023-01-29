<script setup>
import { ORDER_STATUS } from "@/router/constants";

// get props from parent component, string required
const props = defineProps({
  status: {
    type: String,
    required: true,
  },
});
</script>

<template>
  <div>
    <span
      v-if="props.status === ORDER_STATUS.PENDING"
      class="whitespace-nowrap px-3 py-2 text-xs font-medium text-center text-white rounded-lg focus:outline-none text-white bg-grey-700 hover:bg-grey-800 focus:ring-4 focus:ring-grey-300 dark:bg-grey-600 dark:hover:bg-grey-700 dark:focus:ring-grey-800"
    >
      En attente d'un chauffeur
    </span>

    <span
      v-if="props.status === ORDER_STATUS.SHIPPING"
      class="whitespace-nowrap px-3 py-2 text-xs font-medium text-center text-white rounded-lg focus:outline-none text-white bg-yellow-700 hover:bg-yellow-800 focus:ring-4 focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-900"
    >
      En cours de livraison
    </span>

    <span
      v-if="props.status === ORDER_STATUS.DONE"
      class="whitespace-nowrap px-3 py-2 text-xs font-medium text-center text-white rounded-lg focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-900"
    >
      Livré
    </span>
  </div>
</template>
