<script setup>
import { getAllOrders, takeOrder, validateOrder } from "@/api/order";
import { USER_STATUS } from "@/router/constants";
import { onMounted, reactive, inject } from "vue";
import OrderStatus from "../../components/OrderStatus.vue";
import KycForm from "../../components/KycForm.vue";

const orderList = reactive({ value: [] });
const currentUser = inject("auth_user");

const kyc = currentUser.value.kyc?.status ?? null;

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
const handleValidateOrderReceipt = (id) => {
  validateOrder(id)
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
  return;
};
</script>

<template>
  <div class="container mx-auto px-4 sm:px-8 my-5">
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
      <table v-if="orderList.value.length > 0" class="w-full text-sm text-left text-gray-400">
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
            <td class="px-6 py-4">
              <OrderStatus :status="item.status" />
            </td>
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
                data-cy="orders-take-button"
              >
                Prendre en charge
              </button>
              <button
                class="block w-full px-4 py-2 mt-6 font-medium text-white uppercase transition-colors duration-200 transform bg-green-500 rounded-md hover:bg-green-600 focus:outline-none focus:bg-green-600"
                v-if="currentUser.value.isDeliverer && item.status === 'SHIPPING'"
                @click="handleValidateOrderReceipt(item.id)"
                data-cy="orders-confirm-button"
              >
                Valider réception
              </button>
              <router-link
                :to="{ name: 'order-detail', params: { id: item.id } }"
                v-if="!currentUser.value.isDeliverer && !currentUser.value.isAdmin"
              >
                <button
                  class="block w-full px-4 py-2 mt-6 font-medium text-white uppercase transition-colors duration-200 transform bg-green-500 rounded-md hover:bg-green-600 focus:outline-none focus:bg-green-600"
                >
                  Détails
                </button>
              </router-link>
              <router-link
                :to="{ name: 'admin-order', params: { id: item.id } }"
                v-if="currentUser.value.isAdmin"
              >
                <button
                  class="block w-full px-4 py-2 mt-6 font-medium text-white uppercase transition-colors duration-200 transform bg-green-500 rounded-md hover:bg-green-600 focus:outline-none focus:bg-green-600"
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
                  data-cy="orders-leave-review-button"
                >
                  Laisser un avis
                </button>
              </router-link>
            </td>
          </tr>
        </tbody>
      </table>
      <div
        v-else-if="currentUser.value.status === USER_STATUS.OPERATIVE || USER_STATUS.isClient"
        class="text-center py-4"
      >
        <p class="text-gray-400">Aucune commande en cours</p>
      </div>
    </div>
    <div v-if="currentUser.value.isDeliverer && kyc !== 'VALIDATED'">
      <KycForm />
    </div>
  </div>
</template>

<style scoped></style>
