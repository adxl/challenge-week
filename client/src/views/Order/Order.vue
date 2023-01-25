<script setup>
import { getOrder } from "@/api/order";
import { reactive, onMounted, inject } from "vue";
import { useRouter } from "vue-router";

import { sendDelivererReview, sendProductReview } from "@/api/reviews";

import StarIcon from "@/components/icons/StarIcon.vue";

const notationRange = Array(5)
  .fill(null)
  .map((_, i) => i);

const order = reactive({ value: {} });

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
const currentUser = inject("auth_user");

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

function handleReviewProduct(review, product, rating) {
  sendProductReview(review, { product, rating, originOrder: order["@id"] })
    .then(() => {
      loadOrder();
    })
    .catch((error) => {
      console.log(error);
    });
}

onMounted(() => {
  loadOrder();
});
</script>

<template>
  <div class="max-w-5xl pt-5 w-full border rounded-lg shadow-md bg-gray-800 border-gray-700">
    <router-link
      class="text-white pl-5"
      :to="currentUser.value.isAdmin ? { name: 'admin-orders' } : { name: 'orders' }"
      >&lt; Retour</router-link
    >
    <h5 class="my-2 text-2xl text-center font-bold tracking-tight text-white">
      Commande N° {{ order.value.id }}
    </h5>
    <div class="flow-root">
      <ul role="list" class="divide-y divide-gray-700">
        <li class="py-3 sm:py-4">
          <div class="flex items-center justify-between px-5">
            <p class="text-lg font-medium text-white">Client :</p>
            <p class="text-lg font-medium truncate text-white">
              {{ order.value.client?.firstname }}
              {{ order.value.client?.lastname }}
            </p>
          </div>
          <div class="flex items-center justify-between px-5">
            <p class="text-lg font-medium text-white">Adresse :</p>
            <p class="text-md font-medium truncate text-white">
              {{ order.value.client?.address }}
            </p>
          </div>
        </li>
        <li class="py-3 sm:py-4">
          <div class="flex items-center justify-around mb-3">
            <p class="text-2xl font-medium text-white">Produits</p>
          </div>
          <table class="w-full text-sm text-left text-gray-400">
            <thead class="text-xs uppercase bg-gray-700 text-gray-400">
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
                class="border-b border-gray-700"
              >
                <td class="px-6 py-4">{{ product.product.name }}</td>
                <td class="px-6 py-4">{{ product.product.price }}€</td>
                <td class="px-6 py-4">
                  {{ product.quantity }}&nbsp;x&nbsp;{{ product.product.type.unit }}&nbsp;{{
                    product.product.type.label
                  }}
                </td>
                <td class="px-6 py-4">
                  {{ (product.quantity * product.product.price).toFixed(2) }} €
                </td>
              </tr>
            </tbody>
            <tfoot>
              <tr class="font-semibold text-white">
                <th scope="row" class="px-6 py-3 text-base">Total</th>
                <th class="px-6 py-3" colspan="2"></th>
                <th class="px-6 py-3">
                  {{
                    order.value?.products?.reduce(
                      (total, p) => total + Number((p.quantity * p.product.price).toFixed(2)),
                      0
                    )
                  }}
                  €
                </th>
              </tr>
            </tfoot>
          </table>
        </li>
        <div v-if="order.value.status === 'DONE'">
          <li class="py-3 sm:py-4 px-5">
            <div class="flex items-center justify-around mb-3">
              <p class="text-2xl font-medium text-white">Avis sur la commande</p>
            </div>
            <div class="mb-10">
              <div v-if="order.value?.delivererReview?.id">
                <div class="text-white">
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
            </div>

            <div>
              <h1 class="text-white text-2xl mb-5">Avis sur les produits:</h1>
              <div v-for="review in order.value.productReviews" :key="review.id" class="text-white">
                <div class="flex items-center mb-5">
                  <div class="flex items-center">
                    <p class="whitespace-nowrap mr-3">{{ review.product.name }}:</p>
                    <button
                      class="mr-2 whitespace-nowrap block w-full px-4 py-2 font-medium text-white transition-colors duration-200 transform rounded-md focus:outline-none"
                      :class="[
                        {
                          'bg-purple-500 hover:bg-purple-600 focus:bg-purple-600 cursor-not-allowed':
                            review.rating === false,
                        },
                        {
                          'bg-gray-500 hover:bg-gray-600 focus:bg-gray-600 unselected':
                            review.rating === true,
                        },
                      ]"
                      @click="handleReviewProduct(review.id, review.product['@id'], false)"
                      :disabled="!review.rating"
                    >
                      c'est SOFT 👎
                    </button>
                    <button
                      class="whitespace-nowrap block w-full px-4 py-2 font-medium text-white transition-colors duration-200 transform rounded-md focus:outline-none"
                      :class="[
                        {
                          'bg-green-500 hover:bg-green-600 focus:bg-green-600 cursor-not-allowed':
                            review.rating === true,
                        },
                        {
                          'bg-gray-500 hover:bg-gray-600 focus:bg-gray-600 unselected':
                            review.rating === false,
                        },
                      ]"
                      @click="handleReviewProduct(review.id, review.product['@id'], true)"
                      :disabled="review.rating"
                    >
                      c'est HIGH 💯
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </li>
        </div>
      </ul>
    </div>
  </div>
</template>

<style scoped>
.unselected {
  opacity: 0.2;
}
</style>
