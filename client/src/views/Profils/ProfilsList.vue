<script setup>
import { getClients, getDeliverers } from "@/api/account";
import { USER_STATUS, PROFIL_DELIVERER, PROFIL_USER } from "@/router/constants";
import { onMounted, reactive, ref, watch, inject } from "vue";

const users = reactive({ value: [] });

const isClientProfil = ref(false);
const isDelivererProfil = ref(false);
const currentUser = inject("auth_user");

const props = defineProps({
  source: {
    type: Symbol,
    required: true,
  },
});

function refreshUsers() {
  isClientProfil.value = props.source === PROFIL_USER;
  isDelivererProfil.value = props.source === PROFIL_DELIVERER;

  if (isClientProfil.value) {
    getClients()
      .then((res) => {
        users.value = res.data.items;
      })
      .catch((error) => {
        console.log(error);
      });
  }

  if (isDelivererProfil.value) {
    getDeliverers()
      .then((res) => {
        users.value = res.data.items;
      })
      .catch((error) => {
        console.log(error);
      });
  }
}
watch(props, () => refreshUsers());
onMounted(() => refreshUsers());

// format date as DD/MM/YYYY
const dateFormat = (value) => {
  const date = new Date(value);
  const year = date.getFullYear();
  const month = date.getMonth() + 1;
  const day = date.getDate();
  return `${padTo2Digits(day)}/${padTo2Digits(month)}/${padTo2Digits(year)}`;
};

function padTo2Digits(num) {
  return num.toString().padStart(2, "0");
}

function handleDelete(value) {
  console.log(value);
}
</script>

<template>
  <div class="container mx-auto px-4 sm:px-8">
    <div class="m-4"></div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
      <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead
          class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
        >
          <tr>
            <th scope="col" class="px-6 py-3">Nom</th>
            <th scope="col" class="px-6 py-3">email</th>
            <th scope="col" class="px-6 py-3">adresse</th>
            <th scope="col" class="px-6 py-3">année de naissance</th>
            <th scope="col" class="px-6 py-3">Status</th>
            <th scope="col" class="px-6 py-3"></th>
            <th scope="col" class="px-6 py-3"></th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="user in users.value"
            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
            :key="user.id"
          >
            <td class="px-6 py-4">{{ user.firstname }} {{ user.lastname }}</td>
            <td class="px-6 py-4">{{ user.email }}</td>
            <td class="px-6 py-4">{{ user.address }}</td>
            <td class="px-6 py-4">{{ dateFormat(user.birthday_at) }}</td>
            <td class="px-6 py-4">
              <span
                v-if="user.status === USER_STATUS.ACTIVE"
                class="px-3 py-2 text-xs font-medium text-center text-white rounded-lg focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
              >
                {{ user.status }}
              </span>

              <span
                v-if="user.status === USER_STATUS.INACTIVE"
                class="px-3 py-2 text-xs font-medium text-center text-white rounded-lg focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
              >
                {{ user.status }}
              </span>

              <span
                v-if="user.status === USER_STATUS.OPERATIVE"
                class="px-3 py-2 text-xs font-medium text-center text-white rounded-lg focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-900"
              >
                {{ user.status }}
              </span>

              <span
                v-if="user.status === USER_STATUS.SUSPENDED"
                class="px-3 py-2 text-xs font-medium text-center text-white rounded-lg focus:outline-none text-white bg-orange-700 hover:bg-orange-800 focus:ring-4 focus:ring-orange-300 dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-900"
              >
                {{ user.status }}
              </span>
              <span
                v-if="user.status === USER_STATUS.BANNED"
                class="px-3 py-2 text-xs font-medium text-center text-white rounded-lg focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
              >
                {{ user.status }}
              </span>
            </td>
            <td class="px-6 py-4">
              <router-link
                :to="{
                  params: { id: user.id },
                }"
                class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                >Détail</router-link
              >
            </td>
            <td class="px-6 py-4">
              <button
                @click.prevent="handleDelete(user)"
                type="submit"
                class="font-medium text-blue-600 dark:text-red-500 hover:underline"
              >
                Supprimer
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<style scoped></style>
