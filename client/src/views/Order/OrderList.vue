<script setup>
import { getAllOrders } from "@/api/order";
import { onMounted, reactive } from "vue";

const orderList = reactive([]);

onMounted(() => {
  getAllOrders()
    .then((res) => {
      orderList.value = res.data.items;

      console.log(res);
    })
    .catch((error) => {
      console.log(error);
    });
});
</script>

<template>
  <div class="container mx-auto px-4 sm:px-8">
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
      <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead
          class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
        >
          <tr>
            <th class="px-6 py-4">N° Commande</th>
            <th class="px-6 py-4">Status</th>
            <th class="px-6 py-4">Client</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="item in orderList.value"
            :key="item.id"
            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
          >
            <td class="px-6 py-4">{{ item.id }}</td>
            <td class="px-6 py-4">{{ item.status }}</td>
            <td class="px-6 py-4">
              {{ item.client.firstname }} {{ item.client.lastname }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<style scoped></style>
