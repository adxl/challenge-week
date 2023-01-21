<script setup>
import { getOrder } from "@/api/order";
import { reactive, onMounted, inject } from "vue";
import { useRouter } from "vue-router";

import { sendDelivererReview } from "@/api/reviews";

import StarIcon from "@/components/icons/StarIcon.vue";

const notationRange = Array(5)
  .fill(null)
  .map((_, i) => i);

const order = reactive({ value: {} });

/* const currentUser = inject("auth_user"); */

const delivererReviewInputs = reactive({
  originOrder: null,
  comment: "",
  rating: 1,
});

function handleSendDelivererReview() {
  sendDelivererReview({ ...delivererReviewInputs })
    .then(() => {
      loadOrder();
    })
    .catch((error) => {
      console.log(error);
    });
}

const route = useRouter();
const id = route.currentRoute.value.params.id ?? null;

function loadOrder() {
  getOrder(id)
    .then(({ data }) => {
      order.value = data;
      delivererReviewInputs.originOrder = data["@id"];
    })
    .catch(() => {
      route.push({ name: "orders" });
    });
}

onMounted(() => {
  loadOrder();
});
</script>

<template>
  <div
    class="max-w-5xl pt-5 w-full bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700"
  >
    <router-link class="text-white pl-5" :to="{ name: 'orders' }">&lt; Retour</router-link>
    <h5 class="my-2 text-2xl text-center font-bold tracking-tight text-gray-900 dark:text-white">
      Commande N° {{ order.value.id }}
    </h5>
    <div class="flow-root">
      <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
        <li class="py-3 sm:py-4">
          <div class="flex items-center justify-between px-5">
            <p class="text-lg font-medium text-gray-900 dark:text-white">Client :</p>
            <p class="text-lg font-medium text-gray-900 truncate dark:text-white">
              {{ order.value.client?.firstname }}
              {{ order.value.client?.lastname }}
            </p>
          </div>
          <div class="flex items-center justify-between px-5">
            <p class="text-lg font-medium text-gray-900 dark:text-white">Adresse :</p>
            <p class="text-md font-medium text-gray-500 truncate dark:text-white">
              {{ order.value.client?.address }}
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
                <th class="px-4 py-2">Prix</th>
                <th class="px-4 py-2">Quantité</th>
                <th class="px-4 py-2">Total</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="product in order.value.products"
                :key="product.id"
                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
              >
                <td class="px-6 py-4">{{ product.product.name }}</td>
                <td class="px-6 py-4">{{ product.product.price }}€</td>
                <td class="px-6 py-4">{{ product.quantity }}</td>
                <td class="px-6 py-4">
                  {{ (product.quantity * product.product.price).toFixed(2) }}€
                </td>
              </tr>
            </tbody>
          </table>
        </li>
        <li class="py-3 sm:py-4 px-5">
          <div class="flex items-center justify-around mb-3">
            <p class="text-2xl font-medium text-gray-900 dark:text-white">Avis sur la commande</p>
          </div>
          <div v-if="order.value?.delivererReview?.id">
            <div class="dark:text-white">
              <h1 class="text-2xl mb-5">Avis sur la livraison:</h1>
              <div class="flex items-center">
                <p>Note :</p>
                <div class="flex items-center">
                  <div v-for="item in notationRange" :key="item">
                    <StarIcon :selected="item < order.value?.delivererReview?.rating" />
                  </div>
                </div>
              </div>
              <div class="flex items-center">
                <p>Commentaire :&nbsp;</p>
                <q>{{ order.value?.delivererReview?.comment }}</q>
              </div>
            </div>
          </div>
          <div v-else>
            <form @submit.prevent="handleSendDelivererReview">
              <div class="mb-6">
                <div>
                  <label class="block mb-2 text-sm font-medium text-white">Note</label>
                  <div class="flex items-center">
                    <div
                      v-for="item in notationRange"
                      :key="item"
                      @click="delivererReviewInputs.rating = item + 1"
                    >
                      <StarIcon :selected="item < delivererReviewInputs.rating" />
                    </div>
                  </div>
                </div>
                <div class="mb-6">
                  <label class="block mb-2 text-sm font-medium text-white">Commentaire</label>
                  <input
                    type="textarea"
                    v-model="delivererReviewInputs.comment"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    required
                  />
                </div>
              </div>

              <button
                type="submit"
                class="mb-10 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center"
              >
                Laisser un avis
              </button>
            </form>
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>

<style scoped></style>
