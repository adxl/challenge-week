<script setup>
import { getAllOrders, takeOrder } from "@/api/order";
import { onMounted, reactive, inject } from "vue";

const orderList = reactive([]);
const currentUser = inject("auth_user");

onMounted(async () => {
  handleRefreshOrders();
});

const handleTakeOrder = (id) => {
  takeOrder(id, currentUser.value.id)
    .then(() => {
      handleRefreshOrders();
    })
    .catch((error) => {
      console.log(error);
    });
};

const handleRefreshOrders = () => {
  getAllOrders()
    .then(({ data }) => {
      orderList.value = data.items;
    })
    .catch((error) => {
      console.log(error);
    });
};
</script>

<template>
  <div class="container mx-auto px-4 sm:px-8 my-5">
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
      <table class="w-full text-sm text-left text-gray-400">
        <thead class="text-xs uppercase bg-gray-700 text-gray-400">
          <tr>
            <th class="px-6 py-4">N° Commande</th>
            <th class="px-6 py-4">Status</th>
            <th class="px-6 py-4">Client</th>
            <th class="px-6 py-4"></th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="item in orderList.value"
            :key="item.id"
            class="border-b bg-gray-800 border-gray-700"
          >
            <td class="px-6 py-4">{{ item.id }}</td>
            <td class="px-6 py-4">{{ item.status }}</td>
            <td class="px-6 py-4">
              <p class="text-sm font-medium text-white">
                {{ item.client.firstname }} {{ item.client.lastname }}
              </p>
              {{ item.client.address }}
            </td>
            <td class="px-6 py-4">
              <button
                class="block w-full px-4 py-2 mt-6 font-medium text-white uppercase transition-colors duration-200 transform bg-green-500 rounded-md hover:bg-green-600 focus:outline-none focus:bg-green-600"
                v-if="currentUser.value.isDeliverer && item.status === 'PENDING'"
                @click="handleTakeOrder(item.id)"
              >
                Prendre en charge
              </button>
              <button
                class="block w-full px-4 py-2 mt-6 font-medium text-white uppercase transition-colors duration-200 transform bg-green-500 rounded-md hover:bg-green-600 focus:outline-none focus:bg-green-600"
                v-if="currentUser.value.isDeliverer && item.status === 'SHIPPING'"
                @click="() => {}"
              >
                Valider réception
              </button>
              <router-link :to="{ name: 'order-detail', params: { id: item.id } }">
                <button
                  class="block w-full px-4 py-2 mt-6 font-medium text-white uppercase transition-colors duration-200 transform bg-green-500 rounded-md hover:bg-green-600 focus:outline-none focus:bg-green-600"
                  v-if="!currentUser.value.isDeliverer"
                >
                  Détails
                </button>
              </router-link>
              <router-link :to="{ name: 'order-detail', params: { id: item.id } }">
                <button
                  class="block w-full px-4 py-2 mt-6 font-medium text-white uppercase transition-colors duration-200 transform bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600"
                  v-if="
                    currentUser.value.isClient && !item.delivererReview && item.status == 'DONE'
                  "
                >
                  Laisser un avis
                </button>
              </router-link>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<style scoped></style>
