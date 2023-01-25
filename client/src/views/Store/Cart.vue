<script setup>
import { onMounted, reactive, ref, inject } from "vue";
import { getCart, updateCart } from "@/idbHelper";
import { createOrder } from "@/api/order";

const cart = reactive({});
const isModalOpen = ref(false);
const user = inject("auth_user");

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

const handleOrderConfirm = () => {
  isModalOpen.value = false;

  const orders = {
    productsOrder: cart.value.products,
  };

  createOrder(orders).then(async () => {
    cart.value.products = [];
    cart.value.total = 0;
    await updateCart(JSON.parse(JSON.stringify(cart.value)));
  });
};
</script>

<template>
  <div class="container mx-auto px-4 sm:px-8 self-start">
    <div
      class="flex justify-between items-center px-4 py-3 bg-gray-800 text-gray-400 mt-5 rounded-lg shadow-md"
    >
      <h3 class="text-lg leading-6 font-medium text-white">Panier</h3>
      <div class="flex items-center">
        <span class="text-gray-400 mr-2">Total:</span>
        <span class="text-gray-200 font-bold"> {{ cart.value?.total }} € </span>
        <button
          v-if="cart.value?.products.length > 0"
          class="ml-4 px-4 py-2 bg-green-900 text-white rounded-md shadow-md hover:bg-green-800"
          type="button"
          @click="isModalOpen = true"
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
      <table class="w-full text-sm text-left text-gray-400">
        <thead class="text-xs uppercase bg-gray-700 text-gray-400">
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
  <div
    id="defaultModal"
    tabindex="-1"
    v-show="isModalOpen"
    class="fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full justify-center items-center flex bg-black bg-opacity-50"
  >
    <div class="relative w-full h-full max-w-2xl md:h-auto">
      <!-- Modal content -->
      <div class="relative rounded-lg shadow bg-gray-700">
        <!-- Modal header -->
        <div class="flex items-start justify-between p-4 border-b rounded-t border-gray-600">
          <h3 class="text-xl font-semibold text-white">Confirmation de la commande</h3>
          <button
            type="button"
            class="bg-transparent rounded-lg text-sm p-1.5 ml-auto inline-flex items-center hover:bg-gray-600 hover:text-white"
            data-modal-hide="defaultModal"
          >
            <svg
              aria-hidden="true"
              class="w-5 h-5"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fill-rule="evenodd"
                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                clip-rule="evenodd"
              ></path>
            </svg>
            <span class="sr-only">Fermer la boîte de dialogue</span>
          </button>
        </div>
        <!-- Modal body -->
        <div class="p-6 space-y-6">
          <h4 class="text-base leading-relaxed 0 text-gray-400">
            Récapitulatif de votre commande :
          </h4>
          <ul class="text-base leading-relaxed text-gray-400">
            <li>
              <label for="deliver_address" class="block mb-2 text-sm font-medium text-white"
                >Adresse de livraison et de facturation :</label
              >
              <input
                type="text"
                id="deliver_address"
                :value="user.value?.address"
                class="border text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500"
                placeholder="John"
                disabled
                readonly
              />
            </li>
            <li class="mt-5">
              <label for="cart_total" class="block mb-2 text-sm font-medium text-white"
                >Total à payer :</label
              >
              <input
                type="text"
                id="cart_total"
                :value="cart.value?.total + ' €'"
                class="border text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500"
                placeholder="John"
                disabled
                readonly
              />
            </li>
          </ul>
          <small>
            <p class="text-sm leading-relaxed text-gray-400 mt-2">
              En cliquant sur "Commander", vous acceptez les conditions générales de vente.
            </p>
          </small>
        </div>
        <!-- Modal footer -->
        <div class="flex items-center p-6 space-x-2 border-t rounded-b border-gray-600">
          <button
            type="button"
            class="focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center bg-green-600 hover:bg-green-700 focus:ring-green-800"
            @click="handleOrderConfirm"
          >
            Commander
          </button>
          <button
            data-modal-hide="defaultModal"
            type="button"
            class="focus:ring-4 focus:outline-none rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 bg-gray-700 text-gray-300 border-gray-500 hover:text-white hover:bg-gray-600 focus:ring-gray-600"
            @click="isModalOpen = false"
          >
            Annuler
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
