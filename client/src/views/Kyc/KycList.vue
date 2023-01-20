<script setup>
import { getPendingKyc, getValidatedKyc, getRefusedKyc } from "@/api/kyc";
import { onMounted, reactive, ref } from "vue";

const kyc = reactive([]);

const statusActive = ref("PENDING");

onMounted(() => {
  getPendingKyc().then((res) => {
    kyc.value = res.data.items;
  });
});

const STATUS = {
  PENDING: "⌛",
  VALIDATED: "✅",
  REFUSED: "🚫",
};

function getTabClass(value) {
  return [
    {
      "text-blue-600 bg-gray-100": statusActive.value === value,
    },
    "inline-block p-4 rounded-t-lg hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300",
  ];
}

function handleChangeStatus(value) {
  statusActive.value = value;
  switch (value) {
    case "PENDING":
      getPendingKyc().then((res) => {
        kyc.value = res.data.items;
      });
      break;
    case "VALIDATED":
      getValidatedKyc().then((res) => {
        kyc.value = res.data.items;
      });
      break;
    case "REFUSED":
      getRefusedKyc().then((res) => {
        kyc.value = res.data.items;
      });
      break;
    default:
      break;
  }
}
</script>

<template>
  <div class="container mx-auto px-4 sm:px-8">
    <ul
      class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400"
    >
      <li class="mr-2">
        <a
          @click.prevent="handleChangeStatus('PENDING')"
          aria-current="page"
          :class="getTabClass('PENDING')"
          >En Attente</a
        >
      </li>
      <li class="mr-2">
        <a
          @click.prevent="handleChangeStatus('REFUSED')"
          :class="getTabClass('REFUSED')"
          >Refuser</a
        >
      </li>
      <li class="mr-2">
        <a
          @click.prevent="handleChangeStatus('VALIDATED')"
          :class="getTabClass('VALIDATED')"
          >Valider</a
        >
      </li>
    </ul>

    <div class="relative overflow-x-auto shadow-md">
      <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead
          class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
        >
          <tr>
            <th scope="col" class="px-6 py-3">Siret</th>
            <th scope="col" class="px-6 py-3"></th>
            <th scope="col" class="px-6 py-3"></th>
            <th scope="col" class="px-6 py-3"></th>
          </tr>
        </thead>
        <tbody>
          <tr
            :key="item.id"
            v-for="item in kyc.value"
            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
          >
            <td class="px-6 py-4">{{ item.siret }}</td>
            <td class="px-6 py-4">{{ STATUS[item.status] }}</td>
            <td class="px-6 py-4">
              <router-link
                :to="{
                  name: 'product-type',
                  params: { id: item.id },
                }"
                class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                >Edit</router-link
              >
            </td>
            <td class="px-6 py-4">
              <button
                @click.prevent="handleDelete(item)"
                type="submit"
                class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
              >
                Delete
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<style scoped></style>
