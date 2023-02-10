<script setup>
import { USER_STATUS } from "@/router/constants";

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
      v-if="props.status === USER_STATUS.ACTIVE"
      class="whitespace-nowrap px-3 py-2 text-xs font-medium text-center text-white rounded-lg focus:outline-none text-white focus:ring-4 bg-green-600 hover:bg-green-700 focus:ring-green-800"
    >
      {{ props.status }}
    </span>

    <span
      v-if="props.status === USER_STATUS.INACTIVE"
      class="whitespace-nowrap px-3 py-2 text-xs font-medium text-center text-white rounded-lg focus:outline-none text-white focus:ring-4 bg-red-600 hover:bg-red-700 focus:ring-red-900"
    >
      {{ props.status }}
    </span>

    <span
      v-if="props.status === USER_STATUS.SUSPENDED"
      class="whitespace-nowrap px-3 py-2 text-xs font-medium text-center text-white rounded-lg focus:outline-none text-white focus:ring-4 bg-yellow-600 hover:bg-yellow-700 focus:ring-yellow-900"
    >
      {{ props.status }}
    </span>

    <span
      v-if="props.status === USER_STATUS.OPERATIVE"
      class="whitespace-nowrap px-3 py-2 text-xs font-medium text-center text-white rounded-lg focus:outline-none text-white focus:ring-4 bg-green-600 hover:bg-green-700 focus:ring-green-900"
    >
      {{ props.status }}
    </span>

    <span
      v-if="props.status === USER_STATUS.BANNED"
      class="whitespace-nowrap px-3 py-2 text-xs font-medium text-center text-white rounded-lg focus:outline-none text-white focus:ring-4 bg-red-600 hover:bg-red-700 focus:ring-red-900"
    >
      {{ props.status }}
    </span>
  </div>
</template>
