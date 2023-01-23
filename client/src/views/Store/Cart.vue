<script setup>
import { onMounted, reactive } from "vue";
import { getCart, updateCart } from "@/idbHelper";

const cart = reactive({});

onMounted(() => {
  getCart().then((res) => {
    cart.value = res;
  });
});

const removeFromCart = async (id) => {
  let cartProducts = cart.value.products.filter((product) => {
    if (product.id === id) {
      cart.value.total -= product.price * product.quantity;
      return false;
    }
    return true;
  });

  cart.value.products = cartProducts;

  await updateCart(JSON.parse(JSON.stringify(cart.value)));
};
</script>

<template>
  <div class="container mx-auto px-4 sm:px-8">
    <div
      class="flex justify-between items-center px-4 py-3 bg-white dark:bg-gray-800 dark:text-gray-400 mt-5 rounded-lg shadow-md"
    >
      <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Panier</h3>
      <div class="flex items-center">
        <span class="text-gray-700 dark:text-gray-400 mr-2">Total:</span>
        <span class="text-gray-900 dark:text-gray-200 font-bold"> {{ cart.value?.total }} € </span>
        <button
          v-if="cart.value?.products.length > 0"
          class="ml-4 px-4 py-2 bg-green-900 text-white rounded-md shadow-md hover:bg-green-800"
        >
          <svg
            fill="none"
            class="w-5 h-5 float-left mr-2"
            stroke="currentColor"
            stroke-width="1.5"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
            aria-hidden="true"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"
            ></path>
          </svg>
          Commander
        </button>
        <button
          v-else
          class="ml-4 px-4 py-2 bg-green-900 text-white rounded-md shadow-md disabled:opacity-50"
          disabled
        >
          <svg
            fill="none"
            class="w-5 h-5 float-left mr-2"
            stroke="currentColor"
            stroke-width="1.5"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
            aria-hidden="true"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"
            ></path>
          </svg>
          Commander
        </button>
      </div>
    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-5">
      <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead
          class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
        >
          <tr>
            <th class="px-6 py-4">Produit</th>
            <th class="px-6 py-4">Prix</th>
            <th class="px-6 py-4">Quantité</th>
            <th class="px-6 py-4">Actions</th>
          </tr>
        </thead>
        <tbody v-if="cart.value?.products.length > 0">
          <tr v-for="product in cart.value?.products" :key="product.id">
            <td class="px-6 py-4">{{ product.name }}</td>
            <td class="px-6 py-4">{{ product.price }} €</td>
            <td class="px-6 py-4">{{ product.quantity }}</td>
            <td class="px-6 py-4 flex align-items">
              <button
                class="block w-7 font-medium text-white uppercase transition-colors duration-200 transform bg-red-500 rounded-md hover:bg-red-600 focus:outline-none focus:bg-red-600"
                @click="removeFromCart(product.id)"
              >
                <svg
                  fill="none"
                  stroke="currentColor"
                  stroke-width="1.5"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                  aria-hidden="true"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M6 18L18 6M6 6l12 12"
                  ></path>
                </svg>
              </button>
            </td>
          </tr>
        </tbody>
        <tbody v-else>
          <tr>
            <td class="px-6 py-4" colspan="4">Votre panier est vide</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
