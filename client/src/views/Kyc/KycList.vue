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
    "inline-block p-4 rounded-t-lg hover:bg-gray-700 hover:text-gray-300",
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
      class="flex flex-wrap text-sm font-medium text-center border-b border-gray-700 text-gray-400"
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
        <a @click.prevent="handleChangeStatus('REFUSED')" :class="getTabClass('REFUSED')"
          >Refuser</a
        >
      </li>
      <li class="mr-2">
        <a @click.prevent="handleChangeStatus('VALIDATED')" :class="getTabClass('VALIDATED')"
          >Valider</a
        >
      </li>
    </ul>

    <div class="relative overflow-x-auto shadow-md">
      <table class="w-full text-sm text-left text-gray-400">
        <thead class="text-xs uppercase bg-gray-700 text-gray-400">
          <tr>
            <th scope="col" class="px-6 py-3" colspan="4">Siret</th>
          </tr>
        </thead>
        <tbody>
          <tr :key="item.id" v-for="item in kyc.value" class="border-b bg-gray-800 border-gray-700">
            <td class="px-6 py-4">{{ item.siret }}</td>
            <td class="px-6 py-4">{{ STATUS[item.status] }}</td>
            <td class="px-6 py-4">
              <router-link
                :to="{
                  name: 'admin-kyc',
                  params: { id: item.id },
                }"
                class="font-medium text-blue-500 hover:underline"
                >Edit</router-link
              >
            </td>
            <td class="px-6 py-4">
              <button
                @click.prevent="handleDelete(item)"
                type="submit"
                class="font-medium text-blue-500 hover:underline"
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
