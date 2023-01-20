<script setup>
import { getAllOrders, takeOrder } from "@/api/order";
import { useGetCurrentUser } from "@/services";
import { onMounted, reactive, ref } from "vue";

const orderList = reactive([]);
const currentUser = reactive({});
const pending = ref(false);

onMounted(async () => {
  currentUser.value = await useGetCurrentUser();
  handleRefreshOrders();
});

const handleTakeOrder = (id) => {
  takeOrder(id, currentUser.value.id)
    .then(() => {
      pending.value = false;
      handleRefreshOrders();
    })
    .catch((error) => {
      console.log(error);
    });
};

const handleRefreshOrders = () => {
  getAllOrders()
    .then((res) => {
      orderList.value = res.data.items;

      console.log(res.data.items);

      if (res.data.items.length > 0 && res.data.items[0].status === "PENDING") {
        console.log("pending");
        pending.value = true;
      }
    })
    .catch((error) => {
      console.log(error);
    });
};
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
            <th
              class="px-6 py-4"
              v-if="
                (currentUser.value?.roles.includes('ROLE_DELIVERER') &&
                  !currentUser.value?.roles.includes('ROLE_ADMIN') &&
                  pending === true) ||
                !currentUser.value?.roles.includes('ROLE_DELIVERER')
              "
            >
              Actions
            </th>
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
              {{ item.client.firstname }} {{ item.client.lastname }} {{ pending.value }}
            </td>
            <td
              class="px-6 py-4"
              v-if="
                (currentUser.value?.roles.includes('ROLE_DELIVERER') &&
                  !currentUser.value?.roles.includes('ROLE_ADMIN') &&
                  pending === true) ||
                !currentUser.value?.roles.includes('ROLE_DELIVERER')
              "
            >
              <button
                class="block w-full px-4 py-2 mt-6 font-medium text-white uppercase transition-colors duration-200 transform bg-green-500 rounded-md hover:bg-green-600 focus:outline-none focus:bg-green-600"
                v-if="
                  currentUser.value.roles.includes('ROLE_DELIVERER') &&
                  !currentUser.value.roles.includes('ROLE_ADMIN') &&
                  pending === true
                "
                @click="handleTakeOrder(item.id)"
              >
                Prendre en charge
              </button>
              <router-link :to="{ name: 'order-detail', params: { id: item.id } }">
                <button
                  class="block w-full px-4 py-2 mt-6 font-medium text-white uppercase transition-colors duration-200 transform bg-green-500 rounded-md hover:bg-green-600 focus:outline-none focus:bg-green-600"
                  v-if="!currentUser.value?.roles.includes('ROLE_DELIVERER')"
                >
                  Détails
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
