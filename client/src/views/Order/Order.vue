<script setup>
import { getOrder } from "@/api/order";
import { reactive, onMounted } from "vue";
import { useRouter } from "vue-router";

const order = reactive({
  value: {},
});

const route = useRouter();
const id = route.currentRoute.value.params.id ?? null;

onMounted(() => {
  getOrder(id)
    .then((res) => {
      console.log(res);
      order.value = res.data;
    })
    .catch(() => {
      route.push({ name: "orders" });
    });
});
</script>

<template>
  <div
    class="max-w-sm w-full bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700"
  >
    <h5 class="my-2 text-2xl text-center font-bold tracking-tight text-gray-900 dark:text-white">
      Commande N° {{ order.value.id }}
    </h5>
    <div class="flow-root">
      <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
        <li class="py-3 sm:py-4">
          <div class="flex items-center justify-around">
            <p class="text-lg font-medium text-gray-900 dark:text-white">Client :</p>
            <p class="text-lg font-medium text-gray-900 truncate dark:text-white">
              {{ order.value.client?.firstname }}
              {{ order.value.client?.lastname }}
            </p>
          </div>
        </li>
        <li class="py-3 sm:py-4">
          <div class="flex items-center justify-around mb-3">
            <p class="text-2xl font-medium text-gray-900 dark:text-white">Produits</p>
          </div>
          <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead
              class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
            >
              <tr>
                <th class="px-4 py-2">Nom</th>
                <th class="px-4 py-2">Quantité</th>
                <th class="px-4 py-2">Prix</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="product in order.value.products"
                :key="product.id"
                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
              >
                <td class="px-6 py-4">{{ product.product.name }}</td>
                <td class="px-6 py-4">{{ product.quantity }}</td>
                <td class="px-6 py-4">{{ product.quantity * product.product.price }}€</td>
              </tr>
            </tbody>
          </table>
        </li>
      </ul>
    </div>
  </div>
</template>

<style scoped></style>
