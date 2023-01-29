<script setup>
import { getUser } from "@/api/account";
import { banUser, giveRoleAdmin } from "@/api/user";
import { getOrder } from "@/api/order";
import { useRouter } from "vue-router";
import { onMounted, reactive, ref } from "vue";
import { USER_ROLES } from "@/router/constants";
import { USER_STATUS } from "../../router/constants";
import OrderStatus from "@/components/OrderStatus.vue";
import StarIcon from "@/components/icons/StarIcon.vue";
import ButtonReturnPage from "@/components/ButtonReturnPage.vue";

const notationRange = Array(5)
  .fill(null)
  .map((_, i) => i);

const route = useRouter();
const id = route.currentRoute.value.params.id ?? null;

const user = reactive({});
const orders = ref([]);

const isClientProfil = ref(false);
const isDelivererProfil = ref(false);
const loading = ref(false);

async function getOrders(userOrders) {
  await userOrders.forEach((order) => {
    getOrder(order.id)
      .then((res) => {
        orders.value.push(res.data);
      })
      .catch((error) => {
        console.log(error);
      });
  });
}

const totalPriceOrder = function (orderProduct) {
  let total = 0;
  orderProduct.forEach((productOrder) => {
    total += productOrder.quantity * productOrder.product.price;
  });
  return Math.round((total + Number.EPSILON) * 100) / 100;
};

function handleBanUser() {
  banUser(id)
    .then((res) => {
      user.value.status = USER_STATUS.BANNED;
    })
    .catch((error) => {
      console.log(error);
    });
}

function handleGiveRoleAdmin() {
  giveRoleAdmin(id)
    .then((res) => {
      if (isClientProfil.value) route.replace({ name: "admin-profils-clients" });
      else route.replace({ name: "admin-profils-deliverers" });
    })
    .catch((error) => {
      console.log(error);
    });
}

const dateFormat = function (d) {
  const date = new Date(d);
  const Year = date.getFullYear();
  const Month = (date.getMonth() + 1).toString().padStart(2, "0");
  const Day = date.getDate().toString().padStart(2, "0");
  const Hour = date.getHours();
  const Minute = date.getMinutes();
  return `${Day}-${Month}-${Year} ${Hour}:${Minute}`;
};

onMounted(async () => {
  // setup profil based on client or deliverer
  getUser(id)
    .then(async (res) => {
      user.value = res.data;
      if (user.value.roles.includes(USER_ROLES.ROLE_DELIVERER)) isDelivererProfil.value = true;
      if (user.value.roles.includes(USER_ROLES.ROLE_CLIENT)) isClientProfil.value = true;

      if (isDelivererProfil.value) {
        getOrders(Array.from(user.value.delivererOrders));
        orders.value.sort((a, b) => b.deliverReview.rating - a.deliverReview.rating);
        loading.value = true;
      } else if (isClientProfil.value) {
        getOrders(Array.from(user.value.clientOrders));
        orders.value.sort((a, b) => b.id - a.id);
        loading.value = true;
      } else {
        route.replace({ name: "admin-dashboard" });
      }
    })
    .catch((error) => {
      console.log(error);
    });
});
</script>

<template>
  <div v-if="loading" class="container mx-auto px-4 sm:px-8 mb-6">
    <ButtonReturnPage v-if="isClientProfil" :path="{ name: 'admin-profils-clients' }" />
    <ButtonReturnPage v-if="isDelivererProfil" :path="{ name: 'admin-profils-deliverers' }" />
    <!-- INFO USER -->
    <div
      class="block max-w-md p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700"
    >
      <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
        {{ user.value.firstname }} {{ user.value.lastname }}
      </h5>
      <p class="font-normal text-gray-700 dark:text-gray-400">
        Email : {{ user.value.email }}<br />
        Adresse : {{ user.value.address }}<br />
      </p>
      <div style="width: fit-content">
        <span
          v-if="isClientProfil"
          class="px-3 py-2 text-xs mr-2 font-medium text-center text-white rounded-lg focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
        >
          Client
        </span>
        <span
          v-if="isDelivererProfil"
          class="px-3 py-2 text-xs mr-2 font-medium text-center texat-white rounded-lg focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
        >
          Livreur</span
        >
        <span
          v-if="user.value.status === USER_STATUS.ACTIVE"
          class="px-3 py-2 text-xs font-medium text-center text-white rounded-lg focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
        >
          {{ user.value.status }}
        </span>

        <span
          v-if="user.value.status === USER_STATUS.INACTIVE"
          class="px-3 py-2 text-xs font-medium text-center text-white rounded-lg focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
        >
          {{ user.value.status }}
        </span>

        <span
          v-if="user.value.status === USER_STATUS.OPERATIVE"
          class="px-3 py-2 text-xs font-medium text-center text-white rounded-lg focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-900"
        >
          {{ user.value.status }}
        </span>

        <span
          v-if="user.value.status === USER_STATUS.BANNED"
          class="px-3 py-2 text-xs font-medium text-center text-white rounded-lg focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
        >
          {{ user.value.status }}
        </span>
      </div>
      <div class="flex mt-6">
        <button
          v-if="[USER_STATUS.OPERATIVE, USER_STATUS.ACTIVE].includes(user.value.status)"
          @click="handleBanUser"
          type="button"
          class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
        >
          Bannir cet utilisateur
        </button>
        <button
          v-if="[USER_STATUS.OPERATIVE, USER_STATUS.ACTIVE].includes(user.value.status)"
          @click="handleGiveRoleAdmin"
          type="button"
          class="text-white bg-orange-700 hover:bg-orange-800 focus:outline-none focus:ring-4 focus:ring-orange-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-900"
        >
          Donner le rôle admin
        </button>
        <span
          v-else-if="user.value.status === USER_STATUS.BANNED"
          class="px-3 py-2 text-xs font-medium text-center text-white rounded-lg focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800"
        >
          Cet utilisateur est ban
        </span>
      </div>
    </div>

    <!-- INFO ORDER -->
    <div class="mt-6">
      <div v-if="orders.length" class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
          <thead
            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
          >
            <tr>
              <th scope="col" class="px-6 py-3">#</th>
              <th v-if="isClientProfil" scope="col" class="px-6 py-3">Livreur</th>
              <th v-if="isDelivererProfil" scope="col" class="px-6 py-3">Client</th>
              <th v-if="isDelivererProfil" scope="col" class="px-6 py-3">Adresse</th>
              <th scope="col" class="px-6 py-3">Date</th>
              <th scope="col" class="px-6 py-3">Produits</th>
              <th scope="col" class="px-6 py-3">Total</th>
              <th scope="col" class="px-6 py-3">Status</th>
              <th scope="col" class="px-6 py-3">Note du livreur</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="order in orders"
              :key="order.id"
              class="bg-white border-b dark:bg-gray-900 dark:border-gray-700"
            >
              <th
                scope="row"
                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
              >
                {{ order.id }}
              </th>
              <td class="px-6 py-4">
                <span v-if="isDelivererProfil">
                  {{ order.client.firstname }}<br />
                  {{ order.client.lastname }}
                </span>

                <span v-if="isClientProfil && order.deliverer">
                  {{ order.client.firstname }}<br />
                  {{ order.client.lastname }}
                </span>

                <span v-if="isClientProfil && !order.deliverer"> - </span>
              </td>

              <td class="px-6 py-4" v-if="isDelivererProfil">{{ order.client.address }}</td>
              <td class="px-6 py-4">
                {{ dateFormat(order.createdAt) }}
              </td>
              <td class="px-6 py-4">
                <p
                  v-for="orderProduct in order.products"
                  :key="orderProduct.id"
                  :set="(product = orderProduct.product)"
                >
                  {{ orderProduct.quantity }} {{ product.type.label }} - {{ product.name }} ({{
                    (orderProduct.quantity * product.price).toFixed(2)
                  }}
                  €)
                </p>
              </td>
              <td>{{ totalPriceOrder(order.products) }} €</td>
              <td class="px-6 py-4">
                <OrderStatus :status="order.status" />
              </td>
              <td>
                <div v-if="order.delivererReview?.rating === 0">
                  <div
                    class="text-white text-xs bg-red-700 hover:bg-red-800 my-1 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-1 py-1 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
                    style="width: min-content; padding: 0.7em 0.6em"
                  >
                    BAN
                  </div>
                  {{ order.delivererReview.comment }}
                </div>
                <div v-else-if="order.delivererReview?.rating > 0">
                  <div class="flex items-center">
                    <div v-for="item in notationRange" :key="item">
                      <StarIcon :selected="item < order?.delivererReview?.rating" />
                    </div>
                  </div>
                  {{ order.delivererReview.comment }}
                </div>
                <div
                  v-else
                  class="px-3 py-2 text-xs font-medium text-center text-white rounded-lg focus:outline-none text-white bg-grey-700 hover:bg-grey-800 focus:ring-4 focus:ring-grey-300 dark:bg-grey-600 dark:hover:bg-grey-700 dark:focus:ring-grey-800"
                >
                  Pas encore noté
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div v-else>
        <p class="text-2xl font-semibold text-gray-900">Aucune commande en historique</p>
      </div>
    </div>
  </div>
</template>
